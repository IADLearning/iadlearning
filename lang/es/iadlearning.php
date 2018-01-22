<?php
// This file is part of iAdLearning Moodle Plugin - http://www.iadlearning.com/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Spanish strings for iadlearning module
 *
 * @package    mod_iadlearning
 * @copyright  www.itoptraining.com
 * @author     jose.omedes@itoptraining.com
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['pluginname'] = 'IADLearning';
$string['pluginadministration'] = 'Administración de IADLearning';
$string['load_courses'] = 'Cargar cursos';
$string['iadconnectsettings'] = 'Ajustes de conexión a IADLearning';
$string['linkname'] = 'acceder al curso';
$string['modulenameplural'] = 'IADLearning';
$string['modulename_help'] = 'Este módulo permite el acceso a IADLearning desde Moodle.';
$string['pluginadministration'] = 'Administración de IAD';
$string['addinstance'] = 'Añadir actividad de tipo IADLearning';
$string['select_course'] = 'Seleccionar curso';
$string['iad_ip'] = 'Dirección IP';
$string['iad_ip_help'] = 'Dirección IP de IADLearning.';
$string['secret_key'] = 'Clave secreta';
$string['settings_error'] = 'Algunos ajustes del módulo no están configurados. Por favor, póngase en contacto con el administrador del sistema';
$string['course_access'] = 'Pulse en el siguiente enlace para ';
$string['iad_frontend'] = 'Dirección Front End';
$string['iad_frontend_port'] = 'Puerto para conexión al Front End';
$string['iad_frontend_help'] = 'Dirección utilizada para conectar al Front End de IADLearning (incluyendo http/https)';
$string['iad_frontend_port_help'] = 'Puerto utilizado para conectar al Front End de IADLearning';
$string['iad_backend'] = 'Dirección Back End';
$string['iad_backend_port'] = 'Puerto para conexión al Back End';
$string['iad_frontend_nonsecure'] = 'Front End permite conexiones no HTTPS';
$string['iad_backend_nonsecure'] = 'Front End permite conexiones no HTTPS';
$string['iad_backend_help'] = 'Dirección utilizada para conectar al Back End de IADLearning (con http/https)';
$string['iad_backend_port_help'] = 'Puerto utilizado para conectar al Back End de IADLearning';
$string['iad_frontend_nonsecure_help'] = 'Seleccione esta opción si el Front End no requiere HTTPS';
$string['iad_backend_nonsecure_help'] = 'Seleccione esta opción si el Back End no requiere HTTPS';
$string['iad_access_key_id'] = 'ID de Clave de Acceso';
$string['iad_access_key_id_help'] = 'Identificador de la Clave de Acceso';
$string['iad_secret_access_key'] = 'Clave de Acceso Secreta';
$string['iad_secret_access_key_help'] = 'Clave de Acceso Secreta (proporcionada por el administrador)';
$string['selected_course'] = 'Curso seleccionado previamente';
$string['login_failed'] = 'Se ha producido un error con la combinación de correo electrónico y contraseña. Por favor, inténtelo de nuevo';
$string['view_failed'] = 'Se ha producido un error en la conexión a los contenidos formativos. Por favor, inténtelo de nuevo';

$string['iad_activity'] = 'Actividad';
$string['iad_access_activity'] = 'Acceder al Contenido de la Actividad';
$string['iad_activity_info'] = 'Información de la actividad:';
$string['iad_last_access'] = 'Último acceso';
$string['iad_last_access_unable'] = 'No se ha podido contactar con el servidor para conocer el último acceso';
$string['iad_no_last_access'] = 'NUNCA';
$string['iad_test_info'] = 'Información de tests:';
$string['iad_test_no_info'] = 'No existe información de tests disponible';

$string['iad_test_id'] = 'ID del Test';
$string['iad_test_title'] = 'Título del Test';
$string['iad_test_attempts'] = 'Número de Intentos';
$string['iad_test_score'] = 'Puntuación Actual';

$string['iad_test_user'] = 'Nombre Usuario';

$string['iad_instance_list'] = 'Lista de actividades de tipo IADLearning en el curso:';
$string['iad_instance_name'] = 'Nombre de la Actividad';
$string['iad_instance_course'] = 'Curso en IADLearning';
$string['iad_instance_none'] = 'No existen actividades de tipo IADLearning en este curso';

$string['iad_dt_search'] = 'Búsqueda:';
$string['iad_dt_first'] = 'First';
$string['iad_dt_previous'] = 'Anterior';
$string['iad_dt_next'] = 'Siguiente';
$string['iad_dt_last'] = 'Último';
$string['iad_dt_info'] = 'Mostrando elemento _START_ a _END_ de _TOTAL_ elementos';
$string['iad_dt_infoEmpty'] = 'Mostrando elemento 0 a 0 de 0 elementos';
$string['iad_dt_lengthMenu'] = 'Mostrando _MENU_ elementos';

$string['iad_license_info'] = 'Información sobre la licencia';
$string['iad_name'] = 'Nombre';
$string['iad_lastname'] = 'Apellidos';
$string['iad_email'] = 'Dirección e-mail';
$string['iad_institution'] = 'Institucion';
$string['iad_phone'] = 'Teléfono';
$string['iad_credentials'] = 'Credenciales de acceso a IADLearning';
$string['iad_username'] = 'Nombre de Usuario';
$string['iad_pass'] = 'Contraseña';
$string['iad_autoprovisioning_error'] = 'Se ha producido un error al obtener sus credenciales.';
$string['iad_servercontact_error'] = 'Se ha producido un error al contactar con el servidor de IADLearning.';

$string['iad_get_demo_keys'] = 'Obtener claves de demo';

$string['error_in_service'] = 'Error contactando con el sistema remoto';
$string['format_error'] = 'Este campo requiere un formato distinto';
$string['creator_id_error'] = 'El creador del curso y su ID de usuario deben coincidir';
$string['iad_course_error'] = 'El identificador del curso no es válido';
$string['iad_course_name_error'] = 'El nombre del curso no es válido';
$string['iad_provisioning_error'] = 'No se han podido generar las claves de demo. Contacte con info@itoptraining.com';

// Events.
$string['eventACCESSACTIVITY'] = 'Acceso al Contenido de la Actividad';
$string['eventACCESSIADCOURSE'] = 'Acceso al Curso IADLearning';
$string['eventACCESSIADCOURSEdesc'] = 'El usuario ha accedido al curso de Moodle apuntado por la actividad IADLearning';

