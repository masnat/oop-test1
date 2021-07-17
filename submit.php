<?php 
require_once('Field.class.php');

// $response = [];
if(!isset($_POST)) {
    $response = [
        'success' => false,
        'msg' => 'Method not found!'
    ];
} else {
    $email = (isset($_POST['email']) && $_POST['email']) ? $_POST['email'] : '';
    $password = (isset($_POST['password']) && $_POST['password']) ? $_POST['password'] : '';
    $job = (isset($_POST['job']) && $_POST['job']) ? $_POST['job'] : '';
    $jk = (isset($_POST['jk']) && $_POST['jk']) ? $_POST['jk'] : '';
    $bio = (isset($_POST['bio']) && $_POST['bio']) ? $_POST['bio'] : '';
    $hoby = (isset($_POST['hoby']) && $_POST['hoby']) ? $_POST['hoby'] : '';

    $validation = new FieldValidation();
    $validation->validate($email, 'email', 'required|valid_email');
    $validation->validate($jk, 'jk', 'required');
    $validation->validate($password, 'password', 'required|valid_password');
    $validation->validate($job, 'job', 'required|valid_optional', [
        'Pengembang PHP',
        'Katanya Engineer PHP',
        'Merasa Programer'
    ]);
    if($validation->error()) {
        $response = [
            'success' => false,
            'msg' => 'Validation failed!',
            'errors' => $validation->get_error_message()
        ];
    } else {
        $response = [
            'success' => true,
            'msg' => 'Submit success!',
            'data' => [
                    'email' => $email,
                    'password' => $password,
                    'job' => $job,
                    'jk' => $jk,
                    'bio' => $bio,
                    'hoby' => $hoby
                ]
            ];
        }
    }

echo json_encode($response);

?>