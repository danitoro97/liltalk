<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use app\models\Usuarios;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */
/* @var $form yii\widgets\ActiveForm */
//\Yii::$app->language = 'en-EN';

$data = [
    "America/Nassau" => "America/Nassau",
    "Asia/Thimphu" => "Asia/Thimphu",
    "Africa/Gaborone" => "Africa/Gaborone",
    "Europe/Minsk" => "Europe/Minsk",
    "America/Belize" => "America/Belize",
    "America/St_Johns" => "America/St_Johns",
    "Indian/Cocos" => "Indian/Cocos",
    "Africa/Kinshasa" => "Africa/Kinshasa",
    "Africa/Bangui" => "Africa/Bangui",
    "Africa/Brazzaville" => "Africa/Brazzaville",
    "Europe/Zurich" => "Europe/Zurich",
    "Africa/Abidjan" => "Africa/Abidjan",
    "Pacific/Rarotonga" => "Pacific/Rarotonga",
    "America/Santiago" => "America/Santiago",
    "Africa/Douala" => "Africa/Douala",
    "Asia/Shanghai" => "Asia/Shanghai",
    "America/Bogota" => "America/Bogota",
    "America/Costa_Rica" => "America/Costa_Rica",
    "America/Havana" => "America/Havana",
    "Atlantic/Cape_Verde" => "Atlantic/Cape_Verde",
    "America/Curacao" => "America/Curacao",
    "Indian/Christmas" => "Indian/Christmas",
    "Asia/Nicosia" => "Asia/Nicosia",
    "Europe/Prague" => "Europe/Prague",
    "Europe/Berlin" => "Europe/Berlin",
    "Africa/Djibouti" => "Africa/Djibouti",
    "Europe/Copenhagen" => "Europe/Copenhagen",
    "America/Dominica" => "America/Dominica",
    "America/Santo_Domingo" => "America/Santo_Domingo",
    "Africa/Algiers" => "Africa/Algiers",
    "America/Guayaquil" => "America/Guayaquil",
    "Europe/Tallinn" => "Europe/Tallinn",
    "Africa/Cairo" => "Africa/Cairo",
    "Africa/El_Aaiun" => "Africa/El_Aaiun",
    "Africa/Asmara" => "Africa/Asmara",
    "Europe/Madrid" => "Europe/Madrid",
    "Africa/Addis_Ababa" => "Africa/Addis_Ababa",
    "Europe/Helsinki" => "Europe/Helsinki",
    "Pacific/Fiji" => "Pacific/Fiji",
    "Atlantic/Stanley" => "Atlantic/Stanley",
    "Pacific/Chuuk" => "Pacific/Chuuk",
    "Atlantic/Faroe" => "Atlantic/Faroe",
    "Europe/Paris" => "Europe/Paris",
    "Africa/Libreville" => "Africa/Libreville",
    "Europe/London" => "Europe/London",
    "America/Grenada" => "America/Grenada",
    "Asia/Tbilisi" => "Asia/Tbilisi",
    "America/Cayenne" => "America/Cayenne",
    "Europe/Guernsey" => "Europe/Guernsey",
    "Africa/Accra" => "Africa/Accra",
    "Europe/Gibraltar" => "Europe/Gibraltar",
    "America/Godthab" => "America/Godthab",
    "Africa/Banjul" => "Africa/Banjul",
    "Africa/Conakry" => "Africa/Conakry",
    "America/Guadeloupe" => "America/Guadeloupe",
    "Africa/Malabo" => "Africa/Malabo",
    "Europe/Athens" => "Europe/Athens",
    "Atlantic/South_Georgia" => "Atlantic/South_Georgia",
    "America/Guatemala" => "America/Guatemala",
    "Pacific/Guam" => "Pacific/Guam",
    "Africa/Bissau" => "Africa/Bissau",
    "America/Guyana" => "America/Guyana",
    "Asia/Hong_Kong" => "Asia/Hong_Kong",
    "America/Tegucigalpa" => "America/Tegucigalpa",
    "Europe/Zagreb" => "Europe/Zagreb",
    "America/Port-au-Prince" => "America/Port-au-Prince",
    "Europe/Budapest" => "Europe/Budapest",
    "Asia/Jakarta" => "Asia/Jakarta",
    "Europe/Dublin" => "Europe/Dublin",
    "Asia/Jerusalem" => "Asia/Jerusalem",
    "Europe/Isle_of_Man" => "Europe/Isle_of_Man",
    "Asia/Kolkata" => "Asia/Kolkata",
    "Indian/Chagos" => "Indian/Chagos",
    "Asia/Baghdad" => "Asia/Baghdad",
    "Asia/Tehran" => "Asia/Tehran",
    "Atlantic/Reykjavik" => "Atlantic/Reykjavik",
    "Europe/Rome" => "Europe/Rome",
    "Europe/Jersey" => "Europe/Jersey",
    "America/Jamaica" => "America/Jamaica",
    "Asia/Amman" => "Asia/Amman",
    "Asia/Tokyo" => "Asia/Tokyo",
    "Africa/Nairobi" => "Africa/Nairobi",
    "Asia/Bishkek" => "Asia/Bishkek",
    "Asia/Phnom_Penh" => "Asia/Phnom_Penh",
    "Pacific/Tarawa" => "Pacific/Tarawa",
    "Indian/Comoro" => "Indian/Comoro",
    "America/St_Kitts" => "America/St_Kitts",
    "Asia/Pyongyang" => "Asia/Pyongyang",
    "Asia/Seoul" => "Asia/Seoul",
    "Asia/Kuwait" => "Asia/Kuwait",
    "America/Cayman" => "America/Cayman",
    "Asia/Almaty" => "Asia/Almaty",
    "Asia/Vientiane" => "Asia/Vientiane",
    "Asia/Beirut" => "Asia/Beirut",
    "America/St_Lucia" => "America/St_Lucia",
    "Europe/Vaduz" => "Europe/Vaduz",
    "Asia/Colombo" => "Asia/Colombo",
    "Africa/Monrovia" => "Africa/Monrovia",
    "Africa/Maseru" => "Africa/Maseru",
    "Europe/Vilnius" => "Europe/Vilnius",
    "Europe/Luxembourg" => "Europe/Luxembourg",
    "Europe/Riga" => "Europe/Riga",
    "Africa/Tripoli" => "Africa/Tripoli",
    "Africa/Casablanca" => "Africa/Casablanca",
    "Europe/Monaco" => "Europe/Monaco",
    "Europe/Chisinau" => "Europe/Chisinau",
    "Europe/Podgorica" => "Europe/Podgorica",
    "America/Marigot" => "America/Marigot",
    "Indian/Antananarivo" => "Indian/Antananarivo",
    "Pacific/Majuro" => "Pacific/Majuro",
    "Europe/Skopje" => "Europe/Skopje",
    "Africa/Bamako" => "Africa/Bamako",
    "Asia/Rangoon" => "Asia/Rangoon",
    "Asia/Ulaanbaatar" => "Asia/Ulaanbaatar",
    "Asia/Macau" => "Asia/Macau",
    "Pacific/Saipan" => "Pacific/Saipan",
    "America/Martinique" => "America/Martinique",
    "Africa/Nouakchott" => "Africa/Nouakchott",
    "America/Montserrat" => "America/Montserrat",
    "Europe/Malta" => "Europe/Malta",
    "Indian/Mauritius" => "Indian/Mauritius",
    "Indian/Maldives" => "Indian/Maldives",
    "Africa/Blantyre" => "Africa/Blantyre",
    "America/Mexico_City" => "America/Mexico_City",
    "Asia/Kuala_Lumpur" => "Asia/Kuala_Lumpur",
    "Africa/Maputo" => "Africa/Maputo",
    "Africa/Windhoek" => "Africa/Windhoek",
    "Pacific/Noumea" => "Pacific/Noumea",
    "Africa/Niamey" => "Africa/Niamey",
    "Pacific/Norfolk" => "Pacific/Norfolk",
    "Africa/Lagos" => "Africa/Lagos",
    "America/Managua" => "America/Managua",
    "Europe/Amsterdam" => "Europe/Amsterdam",
    "Europe/Oslo" => "Europe/Oslo",
    "Asia/Kathmandu" => "Asia/Kathmandu",
    "Pacific/Nauru" => "Pacific/Nauru",
    "Pacific/Niue" => "Pacific/Niue",
    "Pacific/Auckland" => "Pacific/Auckland",
    "Asia/Muscat" => "Asia/Muscat",
    "America/Panama" => "America/Panama",
    "America/Lima" => "America/Lima",
    "Pacific/Tahiti" => "Pacific/Tahiti",
    "Pacific/Port_Moresby" => "Pacific/Port_Moresby",
    "Asia/Manila" => "Asia/Manila",
    "Asia/Karachi" => "Asia/Karachi",
    "Europe/Warsaw" => "Europe/Warsaw",
    "America/Miquelon" => "America/Miquelon",
    "Pacific/Pitcairn" => "Pacific/Pitcairn",
    "America/Puerto_Rico" => "America/Puerto_Rico",
    "Asia/Gaza" => "Asia/Gaza",
    "Europe/Lisbon" => "Europe/Lisbon",
    "Pacific/Palau" => "Pacific/Palau",
    "America/Asuncion" => "America/Asuncion",
    "Asia/Qatar" => "Asia/Qatar",
    "Indian/Reunion" => "Indian/Reunion",
    "Europe/Bucharest" => "Europe/Bucharest",
    "Europe/Belgrade" => "Europe/Belgrade",
    "Europe/Kaliningrad" => "Europe/Kaliningrad",
    "Africa/Kigali" => "Africa/Kigali",
    "Asia/Riyadh" => "Asia/Riyadh",
    "Pacific/Guadalcanal" => "Pacific/Guadalcanal",
    "Indian/Mahe" => "Indian/Mahe",
    "Africa/Khartoum" => "Africa/Khartoum",
    "Europe/Stockholm" => "Europe/Stockholm",
    "Asia/Singapore" => "Asia/Singapore",
    "Atlantic/St_Helena" => "Atlantic/St_Helena",
    "Europe/Ljubljana" => "Europe/Ljubljana",
    "Arctic/Longyearbyen" => "Arctic/Longyearbyen",
    "Europe/Bratislava" => "Europe/Bratislava",
    "Africa/Freetown" => "Africa/Freetown",
    "Europe/San_Marino" => "Europe/San_Marino",
    "Africa/Dakar" => "Africa/Dakar",
    "Africa/Mogadishu" => "Africa/Mogadishu",
    "America/Paramaribo" => "America/Paramaribo",
    "Africa/Juba" => "Africa/Juba",
    "Africa/Sao_Tome" => "Africa/Sao_Tome",
    "America/El_Salvador" => "America/El_Salvador",
    "America/Lower_Princes" => "America/Lower_Princes",
    "Asia/Damascus" => "Asia/Damascus",
    "Africa/Mbabane" => "Africa/Mbabane",
    "America/Grand_Turk" => "America/Grand_Turk",
    "Africa/Ndjamena" => "Africa/Ndjamena",
    "Indian/Kerguelen" => "Indian/Kerguelen",
    "Africa/Lome" => "Africa/Lome",
    "Asia/Bangkok" => "Asia/Bangkok",
    "Asia/Dushanbe" => "Asia/Dushanbe",
    "Pacific/Fakaofo" => "Pacific/Fakaofo",
    "Asia/Dili" => "Asia/Dili",
    "Asia/Ashgabat" => "Asia/Ashgabat",
    "Africa/Tunis" => "Africa/Tunis",
    "Pacific/Tongatapu" => "Pacific/Tongatapu",
    "Europe/Istanbul" => "Europe/Istanbul",
    "America/Port_of_Spain" => "America/Port_of_Spain",
    "Pacific/Funafuti" => "Pacific/Funafuti",
    "Asia/Taipei" => "Asia/Taipei",
    "Africa/Dar_es_Salaam" => "Africa/Dar_es_Salaam",
    "Europe/Kiev" => "Europe/Kiev",
    "Africa/Kampala" => "Africa/Kampala",
    "Pacific/Johnston" => "Pacific/Johnston",
    "America/New_York" => "America/New_York",
    "America/Montevideo" => "America/Montevideo",
    "Asia/Samarkand" => "Asia/Samarkand",
    "Europe/Vatican" => "Europe/Vatican",
    "America/St_Vincent" => "America/St_Vincent",
    "America/Caracas" => "America/Caracas",
    "America/Tortola" => "America/Tortola",
    "America/St_Thomas" => "America/St_Thomas",
    "Asia/Ho_Chi_Minh" => "Asia/Ho_Chi_Minh",
    "Pacific/Efate" => "Pacific/Efate",
    "Pacific/Wallis" => "Pacific/Wallis",
    "Pacific/Apia" => "Pacific/Apia",
    "Asia/Aden" => "Asia/Aden",
    "Indian/Mayotte" => "Indian/Mayotte",
    "Africa/Johannesburg" => "Africa/Johannesburg",
    "Africa/Lusaka" => "Africa/Lusaka",
    "Africa/Harare" => "Africa/Harare",
];
asort($data,SORT_STRING);
?>

<div class="usuarios-form">

    <?php $form = ActiveForm::begin(['id' => 'create-form']); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password_repeat')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'zona_horaria')->widget(Select2::classname(), [
        'data' => $data,
        'options' => ['placeholder' => Yii::t('app','Selecciona una zona ...')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'biografia')->textarea() ?>
    <?php if ($model->scenario == Usuarios::ESCENARIO_ACTUALIZAR ): ?>
        <?= $form->field($model, 'imageFile')->fileInput() ?>
    <?php endif ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Guardar'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
