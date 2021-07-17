<?php 
    require_once('Page.class.php');
    require_once('Field.class.php');

    $page = new Page('Halaman Satu');

    $email = new Field(Field::TextInput, 
        [
            'name' => 'email', 
            'label' => 'Email',
            'class' => 'form-control',
            'type' => 'email',
            'placeholder' => 'Email',
            'required' => true
        ]
    );
    $password = new Field(Field::TextPassword, 
        [
            'name' => 'password', 
            'label' => 'Password',
            'class' => 'form-control',
            'placeholder' => 'Password',
            'required' => true
        ]
    );
    $jobs = new Field(Field::Select, 
        [
            'name' => 'job', 
            'label' => 'JOB',
            'class' => 'form-control',
            'placeholder' => 'JOB',
            'required' => true
        ],
        [
            [
                'value' => 'Pengembang PHP',
                // 'label' => 'Pengembang PHP',
                'data-id' => '1',
                'selected' => true
            ],
            'Katanya Engineer PHP',
            'Merasa Programer'
        ]
    );
    $jk = new Field(Field::Radio, 
        [
            'name' => 'jk',
            'label' => 'Jenis Kelamin',
            'required' => true
        ],
        [
            [
                'value' => 'Laki-laki',
                'data-id' => '1',
                'checked' => true,
                'id' => 'jk_l'
            ],
            [
                'value' => 'Perempuan',
                'data-id' => '2',
                'id' => 'jk_p'
            ]
        ]
    );
    $hoby = new Field(Field::Checkbox, 
        [
            'name' => 'hoby[]',
            'label' => 'Hoby',
        ],
        [
            [
                'value' => 'Main',
                'data-id' => '1',
                'checked' => true,
                'id' => 'hb_main'
            ],
            [
                'value' => 'Rebahan',
                'data-id' => '2',
                'id' => 'hb_rebahan'
            ],
            [
                'value' => 'Futsal',
                'data-id' => '3',
                'id' => 'hb_futsal'
            ]
        ]
    );
    $bio = new Field(Field::Textarea, 
        [
            'name' => 'bio', 
            'label' => 'Bio',
            'class' => 'form-control',
            'placeholder' => 'Bio',
            'rows' => 3
            // 'required' => true
        ]
    );
    $page->addForm('http://localhost/labs/submit.php', [$email, $password, $jobs, $jk, $hoby, $bio]);
    $page->render();
?>