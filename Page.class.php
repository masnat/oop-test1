<?php
    require_once('Field.class.php');
    class Page {
        public $title;
        private $form;
        
        function __construct($title)
        {
            $this->title = $title;
        }

        public function addForm(String $url = "", Array $fields = []): void {
            $input = '';
            foreach($fields as $field) {
                $input .= $field->element;
            }

            $this->form = '<h1><u>'.$this->title.'</u></h1>
                <form action="'.$url.'" method="post" class="form-horizontal" autocomplete="off">'
                    .$input.
                    '<div class="form-group">
                        <div class="col-sm-12 text-right">
                            <button type="submit" class="btn btn-info">Submit</button>
                        </div>
                    </div>
                </form>
                <script>
                    $(document).ready(function() {
                        $("form").submit(function(e) {
                            e.preventDefault();
                            let form = $(this);
                            form.find("[type=submit]").attr("disabled", true);
                            $.ajax({
                                url: form.attr("action"),
                                method: form.attr("method"),
                                dataType: "json",
                                data: form.serialize(),
                                success: function(res) {
                                    form.find("[type=submit]").removeAttr("disabled");

                                    // failed
                                    if(res.success === false) {
                                        // get msg if any
                                        let errors = res.errors;
                                        let li = "";
                                        for(let er in errors) {
                                            if(errors.hasOwnProperty(er)) {
                                                li += "<li>" + errors[er] + "</li>";
                                            }
                                        }
                                        let ul = "<ul>"+li+"</ul>";
                                        $("#info .modal-header").removeClass("bg-success").addClass("bg-danger");
                                        $("#info .modal-body").html("<p class=\"badge badge-danger\">"+res.msg+"</p><h5>Error:</h5>"+ul);
                                        $("#info").modal("show");
                                        return false;
                                    }

                                    // success
                                    let data = res.data;
                                    let li = "";
                                    for(let dt in data) {
                                        if(data.hasOwnProperty(dt)) {
                                            li += "<li>"+ dt + " : " + data[dt] + "</li>";
                                        }
                                    }
                                    let ul = "<ul>"+li+"</ul>";
                                    $("#info .modal-header").removeClass("bg-danger").addClass("bg-success");
                                    $("#info .modal-body").html("<p class=\"badge badge-success\">"+res.msg+"</p><h5>Data:</h5>"+ul);
                                    $("#info").modal("show");
                                    console.log(res)
                                }
                            })
                        })
                    })
                </script>';
        }

        public function addHeader(): String {
            $header = '<!DOCTYPE html>
                <html lang="en">
                    <head>
                        <meta charset="UTF-8">
                        <meta http-equiv="X-UA-Compatible" content="IE=edge">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <title>'. $this->title .'</title>
                        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
                        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
                        <!-- Latest compiled and minified JavaScript -->
                        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
                    </head>
                    <body>';
            return $header;
        }

        public function addFooter(): String {
            $footer = '<div class="modal fade" id="info" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h1 class="modal-title">Info</h1>
                            </div>
                            <div class="modal-body">
                                
                            </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
                </body>
            </html>';
            return $footer;
        }

        public function render(): void {
            $page = $this->addHeader();
            $page .= '<div class="col-sm-6 col-sm-offset-3">';
            $page .= $this->form;
            $page .= '</div>';
            $page .= $this->addFooter();
            echo $page;
        }
    }
?>