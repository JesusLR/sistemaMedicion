<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExerciseSeeder extends Seeder
{
    public function run(): void
    {
        $exercises = [
            [
                'name' => 'Press de Banca Plano con Barra',
                'description' => 'El press de banca es un ejercicio compuesto para el tren superior que trabaja el pectoral, tríceps y deltoides anterior.',
                'muscle_group' => 'Pecho',
                'primary_muscle' => 'Pectoral Mayor',
                'secondary_muscles' => json_encode(['Tríceps Braquial', 'Deltoides Anterior']),
                'exercise_type' => 'Fuerza',
                'equipment' => 'Barra',
                'difficulty' => 'Intermedio',
                'instructions' => 'Acuéstate en el banco plano, sujeta la barra a una anchura ligeramente superior a la de los hombros, baja la barra de forma controlada hasta tocar el pecho y empuja con fuerza hacia arriba.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sentadilla Trasera con Barra',
                'description' => 'Ejercicio compuesto clave para desarrollar fuerza e hipertrofia en las piernas y glúteos.',
                'muscle_group' => 'Piernas',
                'primary_muscle' => 'Cuádriceps',
                'secondary_muscles' => json_encode(['Glúteo Mayor', 'Isquiotibiales', 'Erectores Espinales']),
                'exercise_type' => 'Fuerza',
                'equipment' => 'Barra',
                'difficulty' => 'Intermedio',
                'instructions' => 'Coloca la barra sobre los trapecios. Separa los pies a la anchura de los hombros. Flexiona las rodillas y caderas bajando el torso verticalmente hasta pasar el paralelo, y regresa a la posición inicial.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Peso Muerto Convencional',
                'description' => 'Ejercicio básico de fuerza de bisagra de cadera que involucra casi toda la cadena posterior.',
                'muscle_group' => 'Espalda',
                'primary_muscle' => 'Erectores Espinales',
                'secondary_muscles' => json_encode(['Isquiotibiales', 'Glúteo Mayor', 'Trapecios']),
                'exercise_type' => 'Fuerza',
                'equipment' => 'Barra',
                'difficulty' => 'Avanzado',
                'instructions' => 'Párate frente a la barra con los pies a la anchura de la cadera. Flexiona las caderas y rodillas para agarrar la barra. Mantén la espalda recta y empuja con los talones extendiendo rodillas y caderas simultáneamente hasta estar de pie.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Dominadas Pronas',
                'description' => 'Excelente ejercicio de tracción vertical para ensanchar la espalda.',
                'muscle_group' => 'Espalda',
                'primary_muscle' => 'Dorsal Ancho',
                'secondary_muscles' => json_encode(['Bíceps Braquial', 'Trapecio Medio', 'Braquial']),
                'exercise_type' => 'Fuerza',
                'equipment' => 'Peso Corporal',
                'difficulty' => 'Intermedio',
                'instructions' => 'Cuélgate de una barra con agarre prono (palmas hacia adelante) más ancho que los hombros. Tira de tu cuerpo hacia arriba retrayendo las escápulas hasta que tu barbilla pase la barra. Baja de forma controlada.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Curl de Bíceps con Mancuernas',
                'description' => 'Ejercicio de aislamiento para los flexores de codo.',
                'muscle_group' => 'Brazos',
                'primary_muscle' => 'Bíceps Braquial',
                'secondary_muscles' => json_encode(['Braquiorradial', 'Braquial']),
                'exercise_type' => 'Aislamiento',
                'equipment' => 'Mancuernas',
                'difficulty' => 'Principiante',
                'instructions' => 'Sujeta una mancuerna en cada mano de pie, con las palmas hacia arriba. Flexiona los codos manteniendo la parte superior del brazo pegada al cuerpo, y desciende lentamente.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Extensión de Tríceps en Polea Alta con Cuerda',
                'description' => 'Aislamiento para trabajar la porción lateral y medial del tríceps.',
                'muscle_group' => 'Brazos',
                'primary_muscle' => 'Tríceps Braquial',
                'secondary_muscles' => json_encode(['Ancóneo']),
                'exercise_type' => 'Aislamiento',
                'equipment' => 'Cable',
                'difficulty' => 'Principiante',
                'instructions' => 'Sujeta la cuerda de una polea alta. Flexiona los codos a 90 grados y manténlos inmóviles a los lados del torso. Extiende los codos llevando las manos hacia abajo y abriendo la cuerda al final del movimiento.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Press Militar con Barra de Pie',
                'description' => 'Ejercicio compuesto muy demandante para hombros y fuerza del core.',
                'muscle_group' => 'Hombros',
                'primary_muscle' => 'Deltoides Anterior',
                'secondary_muscles' => json_encode(['Tríceps Braquial', 'Serrato Anterior', 'Deltoides Lateral']),
                'exercise_type' => 'Fuerza',
                'equipment' => 'Barra',
                'difficulty' => 'Intermedio',
                'instructions' => 'Sujeta la barra a la altura del pecho superior, de pie con el abdomen contraído. Empuja la barra verticalmente sobre tu cabeza extendiendo los brazos y bloqueando ligeramente al final.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Elevaciones Laterales con Mancuernas',
                'description' => 'Aislamiento para añadir anchura a los hombros esculpiendo el deltoides lateral.',
                'muscle_group' => 'Hombros',
                'primary_muscle' => 'Deltoides Lateral',
                'secondary_muscles' => json_encode(['Deltoides Anterior', 'Trapecio Superior']),
                'exercise_type' => 'Aislamiento',
                'equipment' => 'Mancuernas',
                'difficulty' => 'Principiante',
                'instructions' => 'Sujeta las mancuernas a los lados de los muslos de pie. Levanta los brazos lateralmente con una ligera flexión de codo hasta que queden paralelos al suelo y vuelve a bajar controlando el peso.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('exercises')->insert($exercises);
    }
}
