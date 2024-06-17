<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            // Temas generales
            'Tecnología', 'Ciencia', 'Historia', 'Música', 'Arte', 'Literatura', 
            'Cine', 'Deportes', 'Viajes', 'Comida', 'Moda', 'Salud', 

            // Subcategorías de tecnología
            'Programación', 'Desarrollo web', 'Ciberseguridad', 'Hardware', 'Software', 
            'Inteligencia artificial', 'Robótica', 'Electrónica',

            // Subcategorías de ciencia
            'Física', 'Química', 'Biología', 'Astronomía', 'Matemáticas', 
            'Medicina', 'Geología', 'Ecología', 

            // Subcategorías de historia
            'Historia antigua', 'Edad media', 'Edad moderna', 'Historia contemporánea', 
            'Historia de América', 'Historia de Europa', 'Historia de Asia',

            // Subcategorías de música
            'Rock', 'Pop', 'Hip hop', 'Clásica', 'Jazz', 'Folk', 'Electrónica', 

            // Subcategorías de arte
            'Pintura', 'Escultura', 'Arquitectura', 'Fotografía', 'Cine', 'Música',
            'Teatro', 'Danza', 'Diseño', 'Literatura',

            // Subcategorías de literatura
            'Novela', 'Poesía', 'Teatro', 'Ensayo', 'Cuento', 'Biografía',

            // Subcategorías de cine
            'Acción', 'Comedia', 'Drama', 'Terror', 'Ciencia ficción', 
            'Fantasía', 'Romance', 'Animación', 

            // Subcategorías de deportes
            'Fútbol', 'Baloncesto', 'Béisbol', 'Tenis', 'Atletismo', 
            'Natación', 'Ciclismo', 'Golf', 

            // Subcategorías de viajes
            'Europa', 'América', 'Asia', 'África', 'Oceanía', 'Caribe', 
            'Montaña', 'Playa', 'Ciudad', 'Naturaleza', 

            // Subcategorías de comida
            'Cocina italiana', 'Cocina francesa', 'Cocina mexicana', 'Cocina asiática', 
            'Repostería', 'Comida saludable', 'Comida vegetariana', 

            // Subcategorías de moda
            'Ropa', 'Zapatos', 'Accesorios', 'Belleza', 'Cosmética', 
            'Tendencias', 'Estilos', 'Diseñadores', 

            // Subcategorías de salud
            'Nutrición', 'Ejercicio', 'Bienestar', 'Medicina', 'Psicología',
            'Enfermedades', 'Remedios naturales',

            // Temas más específicos
            'Criptomonedas', 'Finanzas personales', 'Medio ambiente', 
            'Educación', 'Política', 'Filosofía', 'Religión', 
            'Cultura', 'Sociedad', 'Psicología', 
            'Emprendimiento', 'Marketing', 'Negocios'
        ];

        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }
    }
}