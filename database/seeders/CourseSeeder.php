<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Course::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        Course::create([
            'title'       => 'Uso responsable de la tecnología y sostenibilidad',
            'description' => 'Descubre cómo tus hábitos digitales impactan el planeta y aprende estrategias concretas para reducir tu huella tecnológica. Este curso te entrega herramientas prácticas para ser un ciudadano digital responsable y comprometido con el medio ambiente.',
            'content'     => [
                'expected_result' => 'Al finalizar, el estudiante comprenderá el impacto ambiental de la tecnología y aplicará hábitos digitales sostenibles en su vida universitaria y cotidiana.',
                'modules' => [
                    [
                        'number'  => 1,
                        'title'   => 'Huella digital y consumo energético',
                        'icon'    => 'bi-plug-fill',
                        'color'   => '#006837',
                        'content' => 'Cada dispositivo tecnológico consume energía durante todo su ciclo de vida: fabricación, transporte, uso y disposición final. El streaming de video representa el 60% del tráfico de internet global y genera millones de toneladas de CO₂ al año. Optimizar el uso de dispositivos, reducir el brillo de pantallas, activar modos de ahorro energético y cerrar aplicaciones en segundo plano son acciones concretas que marcan la diferencia. Los centros de datos que almacenan la nube mundial consumen más electricidad que muchos países enteros.',
                        'key_points' => [
                            'El 70% del consumo energético de un dispositivo ocurre durante su fabricación.',
                            'Una hora de videollamada emite aprox. 150 g de CO₂.',
                            'Reducir la resolución del streaming puede bajar el consumo de datos hasta un 70%.',
                        ],
                        'activity' => [
                            'icon'        => 'bi-journal-check',
                            'type'        => 'Reflexión práctica',
                            'description' => 'Durante 3 días consecutivos, registra el tiempo diario que utilizas tu smartphone, computador y otros dispositivos. Calcula el total de horas semanales y reflexiona en un párrafo sobre qué acciones concretas podrías adoptar para reducir tu consumo energético digital.',
                        ],
                    ],
                    [
                        'number'  => 2,
                        'title'   => 'Residuos electrónicos (e-waste)',
                        'icon'    => 'bi-recycle',
                        'color'   => '#1a7a4a',
                        'content' => 'Los residuos electrónicos (e-waste) son uno de los flujos de basura de crecimiento más rápido del mundo: se generan más de 53 millones de toneladas anuales. Contienen materiales valiosos como oro, plata y cobre, pero también sustancias tóxicas como mercurio, plomo y cadmio. Botar un celular al basurero contamina el suelo y el agua. La reparación, reutilización y reciclaje de dispositivos es fundamental. En Chile existen puntos limpios habilitados para depositar dispositivos en desuso de forma segura.',
                        'key_points' => [
                            'Solo el 17% del e-waste mundial se recicla formalmente.',
                            'Un celular contiene más de 60 elementos de la tabla periódica.',
                            'Reparar un equipo puede extender su vida útil entre 3 y 5 años adicionales.',
                        ],
                        'activity' => [
                            'icon'        => 'bi-geo-alt-fill',
                            'type'        => 'Investigación comunitaria',
                            'description' => 'Busca en tu ciudad al menos un punto limpio o programa de reciclaje de electrónicos (municipio, supermercado, tiendas de tecnología). Comparte la dirección y horarios con mínimo 5 personas de tu entorno familiar o universitario. Documenta la acción con una captura de pantalla o foto.',
                        ],
                    ],
                    [
                        'number'  => 3,
                        'title'   => 'Economía circular y tecnología sostenible',
                        'icon'    => 'bi-arrow-repeat',
                        'color'   => '#00924e',
                        'content' => 'La economía circular propone rediseñar el ciclo de vida de los productos para eliminar los residuos desde el diseño, no al final del proceso. En tecnología esto implica fabricar dispositivos reparables y modulares, utilizar materiales reciclados y extender la vida útil de los equipos. Empresas como Fairphone lideran este modelo con teléfonos 100% modulares. Como consumidores universitarios, podemos rechazar la obsolescencia programada eligiendo marcas con mayor compromiso ambiental y optando por la segunda mano cuando sea posible.',
                        'key_points' => [
                            'La obsolescencia programada acorta artificialmente la vida de los dispositivos.',
                            'Comprar de segunda mano puede reducir la huella de carbono hasta un 80%.',
                            'El sello EPEAT certifica equipos electrónicos con criterios ambientales.',
                        ],
                        'activity' => [
                            'icon'        => 'bi-search',
                            'type'        => 'Análisis comparativo',
                            'description' => 'Investiga 3 marcas de tecnología (ej: Apple, Samsung, Fairphone) y compara sus políticas de sustentabilidad ambiental. ¿Ofrecen programas de reciclaje? ¿Usan materiales reciclados? ¿Sus dispositivos son reparables? Presenta tus hallazgos en una tabla comparativa y elige qué marca elegirías como consumidor responsable.',
                        ],
                    ],
                ],
                'evaluation' => [
                    'title'       => 'Evaluación final del curso',
                    'description' => 'Responde las siguientes preguntas para verificar tus aprendizajes.',
                    'questions'   => [
                        [
                            'number'   => 1,
                            'question' => '¿Cuál es el principal impacto ambiental asociado al uso masivo de streaming de video?',
                            'options'  => [
                                'A' => 'Genera residuos plásticos en los océanos.',
                                'B' => 'Consume grandes cantidades de energía y genera emisiones de CO₂.',
                                'C' => 'Contamina directamente el agua potable.',
                                'D' => 'Produce contaminación acústica en los centros de datos.',
                            ],
                            'correct'      => 'B',
                            'explanation'  => 'Los centros de datos que soportan el streaming global consumen enormes cantidades de electricidad, lo que se traduce en emisiones significativas de gases de efecto invernadero.',
                        ],
                        [
                            'number'   => 2,
                            'question' => '¿Qué son los residuos electrónicos o "e-waste"?',
                            'options'  => [
                                'A' => 'Un software especializado en gestión de reciclaje digital.',
                                'B' => 'Dispositivos electrónicos obsoletos o en desuso que generan residuos tóxicos si no se gestionan correctamente.',
                                'C' => 'Una red de internet de bajo consumo energético.',
                                'D' => 'Programas gubernamentales de ahorro energético.',
                            ],
                            'correct'      => 'B',
                            'explanation'  => 'El e-waste incluye celulares, computadores, tablets y cualquier dispositivo electrónico que ya no se usa. Contienen materiales valiosos pero también tóxicos que requieren gestión especializada.',
                        ],
                        [
                            'number'   => 3,
                            'question' => '¿Cuál es el principio fundamental de la economía circular aplicada a la tecnología?',
                            'options'  => [
                                'A' => 'Producir, usar y desechar los dispositivos lo más rápido posible para estimular la economía.',
                                'B' => 'Importar tecnología de bajo costo sin considerar su origen ni impacto ambiental.',
                                'C' => 'Rediseñar el ciclo de vida de los productos para eliminar residuos, fomentando la reparación y reutilización.',
                                'D' => 'Depender exclusivamente de energías no renovables para producir más dispositivos.',
                            ],
                            'correct'      => 'C',
                            'explanation'  => 'La economía circular busca que los recursos permanezcan en uso el mayor tiempo posible, eliminando el concepto de "basura" al diseñar productos que puedan ser reparados, reutilizados y reciclados.',
                        ],
                    ],
                ],
            ],
        ]);

        Course::create([
            'title'       => 'Reciclaje y gestión de residuos en el campus universitario',
            'description' => 'Conoce los principios de la separación correcta de residuos, el impacto del reciclaje en el ecosistema y cómo liderar iniciativas de gestión ambiental en tu facultad y comunidad universitaria.',
            'content'     => [
                'expected_result' => 'El estudiante será capaz de clasificar residuos correctamente, promover hábitos de reciclaje en su entorno y diseñar una pequeña iniciativa de gestión de residuos en su facultad.',
                'modules' => [
                    [
                        'number'  => 1,
                        'title'   => 'Las 3R: Reducir, Reutilizar, Reciclar',
                        'icon'    => 'bi-recycle',
                        'color'   => '#006837',
                        'content' => 'La jerarquía de las 3R establece un orden de prioridad: primero reducir la generación de residuos, luego reutilizar lo que ya existe, y finalmente reciclar lo que no puede evitarse. Reducir implica comprar solo lo necesario y rechazar empaques innecesarios. Reutilizar significa darle una segunda vida a los objetos. Reciclar es el último recurso y requiere separación correcta en origen.',
                        'key_points' => [
                            'Reducir es siempre más efectivo que reciclar.',
                            'Una botella de plástico tarda 500 años en degradarse.',
                            'El papel reciclado usa 60% menos energía que el papel virgen.',
                        ],
                        'activity' => [
                            'icon'        => 'bi-clipboard-data',
                            'type'        => 'Auditoría de residuos',
                            'description' => 'Realiza una auditoría de los residuos que generas durante una semana en tu hogar o habitación. Clasifícalos por tipo (orgánico, papel, plástico, vidrio, electrónico) y reflexiona sobre cuáles podrías haber evitado o reutilizado.',
                        ],
                    ],
                    [
                        'number'  => 2,
                        'title'   => 'Separación en origen y puntos limpios',
                        'icon'    => 'bi-trash3-fill',
                        'color'   => '#1a7a4a',
                        'content' => 'La separación en origen es el paso más crítico del reciclaje. Si los materiales se mezclan, se contamina toda la fracción y no puede reciclarse. Los colores de contenedores varían por país: en Chile, azul para papel/cartón, amarillo para plásticos y metales, verde para vidrio. Los puntos limpios reciben residuos especiales como pilas, medicamentos y electrónicos que no van al basurero común.',
                        'key_points' => [
                            'Solo el 10% de los chilenos recicla de forma habitual.',
                            'Una pila puede contaminar 600 litros de agua subterránea.',
                            'Separar en origen puede recuperar hasta el 70% de los residuos.',
                        ],
                        'activity' => [
                            'icon'        => 'bi-map',
                            'type'        => 'Mapeo de puntos limpios',
                            'description' => 'Mapea los puntos de reciclaje disponibles dentro de tu campus universitario y en tu barrio. Crea un pequeño directorio con fotografías y compártelo con tus compañeros de curso o en redes sociales usando el hashtag #EcoLearnUDEC.',
                        ],
                    ],
                ],
                'evaluation' => [
                    'title'       => 'Evaluación: Reciclaje en el campus',
                    'description' => 'Responde para validar tus conocimientos sobre gestión de residuos.',
                    'questions'   => [
                        [
                            'number'   => 1,
                            'question' => '¿Cuál es el orden correcto de prioridad en la jerarquía de las 3R?',
                            'options'  => [
                                'A' => 'Reciclar → Reutilizar → Reducir',
                                'B' => 'Reducir → Reutilizar → Reciclar',
                                'C' => 'Reutilizar → Reciclar → Reducir',
                                'D' => 'Las 3R tienen la misma importancia.',
                            ],
                            'correct'      => 'B',
                            'explanation'  => 'Reducir siempre es la acción más impactante pues evita la generación de residuos desde el inicio. Reutilizar extiende la vida útil y reciclar es el último recurso.',
                        ],
                        [
                            'number'   => 2,
                            'question' => '¿Por qué es importante la separación en origen de los residuos?',
                            'options'  => [
                                'A' => 'Porque facilita el trabajo de los camiones recolectores.',
                                'B' => 'Porque si los materiales se mezclan se contaminan y no pueden reciclarse.',
                                'C' => 'Solo importa separar plásticos del resto.',
                                'D' => 'No es relevante, las plantas de reciclaje separan automáticamente todo.',
                            ],
                            'correct'      => 'B',
                            'explanation'  => 'La contaminación cruzada de materiales es la principal razón por la que los residuos que podrían reciclarse terminan en el vertedero. La separación en origen es imprescindible.',
                        ],
                        [
                            'number'   => 3,
                            'question' => '¿Dónde deben depositarse las pilas y baterías usadas?',
                            'options'  => [
                                'A' => 'En el basurero común junto con los residuos domésticos.',
                                'B' => 'En el contenedor de plásticos amarillo.',
                                'C' => 'En puntos limpios especializados o contenedores habilitados para residuos peligrosos.',
                                'D' => 'Pueden tirarse al alcantarillado si están completamente descargadas.',
                            ],
                            'correct'      => 'C',
                            'explanation'  => 'Las pilas contienen metales pesados tóxicos. Deben entregarse en puntos limpios o en los contenedores especiales disponibles en supermercados y tiendas de tecnología.',
                        ],
                    ],
                ],
            ],
        ]);
    }
}
