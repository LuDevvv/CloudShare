<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('categories');

        if ($request->has('categories')) {
            $categoryIds = Category::whereIn('name', $request->categories)->pluck('id');
            $query->whereHas('categories', function ($q) use ($categoryIds) {
                $q->whereIn('categories.id', $categoryIds);
            });
        }

        $users = $query->get();
        return response()->json(['data' => $users]);
    }

    public function show($id)
    {
        try {
            $user = User::with('categories')->findOrFail($id);
            return response()->json(['data' => $user]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve user information.'], 500);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'user_name' => 'sometimes|string|max:255',
            'photo_url' => 'sometimes|url',
            'bio' => 'sometimes|string',
            'categories' => 'sometimes|array',
            'categories.*' => 'sometimes|string|exists:categories,name'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::create($request->all());

        if ($request->has('categories')) {
            $categories = Category::whereIn('name', $request->categories)->get();
            $user->categories()->sync($categories);
        }

        return response()->json(['message' => 'User created successfully', 'data' => $user->load('categories')], 201);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:users,email,' . $id,
            'password' => 'sometimes|required|string|min:8',
            'user_name' => 'sometimes|string|max:255',
            'photo_url' => 'sometimes|url',
            'bio' => 'sometimes|string',
            'categories' => 'sometimes|array',
            'categories.*' => 'sometimes|string|exists:categories,name'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $user = User::findOrFail($id);
            $user->update($request->all());

            if ($request->has('categories')) {
                $categories = Category::whereIn('name', $request->categories)->get();
                $user->categories()->sync($categories);
            }

            return response()->json(['message' => 'User updated successfully', 'data' => $user->load('categories')], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update user information.'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->categories()->detach();
            $user->delete();
            return response()->json(['message' => 'User deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete user.'], 500);
        }
    }
}
