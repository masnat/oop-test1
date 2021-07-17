<?php
    class Field {
        const TextInput = 'TextInput';
        const TextPassword = 'TextPassword';
        const Select = 'Select';
        const Checkbox = 'Checkbox';
        const Radio = 'Radio';
        const Textarea = 'Textarea';
        const Optional = 'Optional';
        public $attributes;
        public $options;

        function __construct(String $TextInput, Array $attributes = [], Array $options = null) {
            $this->attributes = $attributes;

            if($TextInput == Field::TextInput) {
                $this->element = $this->InputText();
            } else if($TextInput == Field::TextPassword) {
                $this->element = $this->InputPassword();
            } else if($TextInput == Field::Textarea) {
                $this->element = $this->Textarea();
            } else if($TextInput == Field::Select) {
                $this->options = $options;
                $this->element = $this->Select();
            } else if($TextInput == Field::Radio) {
                $this->options = $options;
                $this->element = $this->Radio();
            } else if($TextInput == Field::Checkbox) {
                $this->options = $options;
                $this->element = $this->Checkbox();
            }
        }

        function InputText(): String {
            $html_attribute = '';
            $field_label = '';
            foreach($this->attributes as $attr => $val) {
                if($attr == 'label') {
                    $field_label = '<label class="control-label">'.$val.'</label>';
                } else {
                    if($attr == 'required') {
                        $html_attribute .= $attr.' ';
                    } else {
                        $html_attribute .= $attr.'="'.$val.'" ';
                    }
                }
            }

            $element = '<input '.$html_attribute.' />';
            return $this->_div($element, $field_label);
        }

        function InputPassword(): String {
            $html_attribute = '';
            foreach($this->attributes as $attr => $val) {
                if($attr == 'label') {
                    $field_label = '<label class="control-label">'.$val.'</label>';
                } else {
                    if($attr == 'required') {
                        $html_attribute .= $attr.' ';
                    } else {
                        $html_attribute .= $attr.'="'.$val.'" ';
                    }
                }
            }

            $element = '<input type="password" '.$html_attribute.' />';
            return $this->_div($element, $field_label);
        }

        function Textarea(): String {
            $html_attribute = '';
            $value = '';
            foreach($this->attributes as $attr => $val) {
                if($attr == 'value') {
                    $value = $val;
                } else if($attr == 'label') {
                    $field_label = '<label class="control-label">'.$val.'</label>';
                } else {
                    if($attr == 'required') {
                        $html_attribute .= $attr.' ';
                    } else {
                        $html_attribute .= $attr.'="'.$val.'" ';
                    }
                }
            }

            $element = '<textarea '.$html_attribute.'>'.$value.'</textarea>';
            return $this->_div($element, $field_label);
        }

        function Select(): String {
            
            $html_attribute = '';
            foreach($this->attributes as $attr => $val) {
                if($attr == 'label') {
                    $field_label = '<label class="control-label">'.$val.'</label>';
                } else {
                    if($attr == 'required') {
                        $html_attribute .= $attr.' ';
                    } else {
                        $html_attribute .= $attr.'="'.$val.'" ';
                    }
                }
            }

            $options = '<option value="">-:Choose One:-</option>';
            foreach($this->options as $val) {
                $attrs = '';
                if(is_array($val)) {
                    $label = (isset($val['label']) && $val['label']) ? $val['label'] : $val['value'];
                    unset($val['label']);
                    $attrs = $this->get_el_attributes($val);
                } else {
                    $value = $val;
                    $label = $val;
                }
                $options .= '<option '.$attrs.'>'.$label.'</option>';
            }

            $element = '<select '.$html_attribute.' >'.$options.'</select>';
            return $this->_div($element, $field_label);
        }

        function Radio(): String {
            
            $html_attribute = '';
            $field_label = '';
            foreach($this->attributes as $attr => $val) {
                if($attr == 'label') {
                    $field_label = '<label class="control-label">'.$val.'</label>';
                } else {
                    $html_attribute .= $attr.'="'.$val.'" ';
                }
            }

            $options = '';
            foreach($this->options as $val) {
                $attrs = '';
                if(is_array($val)) {
                    // $value = $val['value'];
                    $label = (isset($val['label']) && $val['label']) ? $val['label'] : $val['value'];
                    unset($val['label']);
                    $attrs = $this->get_el_attributes($val);
                } else {
                    $label = $val;
                }
                $options .= '<div class="radio">
                                <label>';
                $options .= '<input type="radio" '.$html_attribute.' '.$attrs.'>'.$label;
                $options .= '</label>
                            </div>';
            }

            $element = $options;
            return $this->_div($element, $field_label);
        }

        function Checkbox(): String {
            
            $html_attribute = '';
            $field_label = '';
            foreach($this->attributes as $attr => $val) {
                if($attr == 'label') {
                    $field_label = '<label class="control-label">'.$val.'</label>';
                } else {
                    $html_attribute .= $attr.'="'.$val.'" ';
                }
            }

            $options = '';
            foreach($this->options as $val) {
                $attrs = '';
                if(is_array($val)) {
                    // $value = $val['value'];
                    $label = (isset($val['label']) && $val['label']) ? $val['label'] : $val['value'];
                    unset($val['label']);
                    $attrs = $this->get_el_attributes($val);
                } else {
                    $label = $val;
                }
                $options .= '<div class="checkbox">
                                <label>';
                $options .= '<input type="checkbox" '.$html_attribute.' '.$attrs.'>'.$label;
                $options .= '</label>
                            </div>';
            }

            $element = $options;
            return $this->_div($element, $field_label);
        }

        function _div(String $element, String $label = ''): String {
            return '<div class="form-group">
                        <div class="col-sm-12">'.
                        $label.
                        $element.   
                        '</div>
                    </div>';
        }

        function get_el_attributes(Array $attributes): String {
            $attr = '';
            // var_dump($attributes);
            if($attributes) {
                foreach($attributes as $key => $val) {
                    if(($key == 'checked' || $key == 'selected')) {
                        $attr .= $val ? ' '.$key.' ' : '';
                    } else {
                        $attr .= ' '.$key.'="'.$val.'" ';
                    }
                }
            }
            return $attr;
        }
    }

    class FieldValidation {
        private $error = [];
        private $value = '';
        private $field_name = '';
        private $validation_types = '';
        private $optional = [];

        function __construct() {
            
        }

        function validate(String $value, String $field_name, String $validation_types, Array $optional = []): void {
            $this->value = $value;
            $this->field_name = $field_name;
            $this->validation_types = $validation_types;
            $this->optional = $optional;

            $this->_validation_type();
        }

        function _validation_type(): void {
            if($this->validation_types) 
            {
                $explode_types = explode('|', $this->validation_types);
                if($explode_types) 
                {
                    foreach($explode_types as $type) 
                    {
                        if($type == 'required')
                            $this->_required();
                        else if($type == 'valid_email')
                            $this->_validate_email();
                        else if($type == 'valid_password')
                            $this->_valid_password();
                        else if($type == 'valid_optional')
                            $this->_validate_optional();
                    }
                }
            }
        }

        function _required(): void {
            if(!$this->value) {
                $this->error['required'] = $this->field_name. ' is required!';
            }
        }

        function _validate_email(): void {
            $email = $this->value;
            if(filter_var($email, FILTER_VALIDATE_EMAIL) === FALSE) {
                $this->error['validate_email'] =  $this->field_name.' is not valid!' ;
            }
        }

        function _valid_password(): void {
            $password = $this->value;
            if(strlen($password) <= 5) {
                $msg = ' must be greater than 5!';
                $this->error['valid_password'] = $this->field_name.' '.$msg;
            }
        }

        function _validate_optional(): void {
            $field = $this->value;
            $optional = $this->optional;
            if(!in_array($field, $optional)) {
                $this->error['valid_option'] = $this->field_name.' is not valid!';
            }
        }

        function error(): bool {
            return $this->error ? true : false;
        }

        function get_error_message(): Array {
            return $this->error;
        }
    }
?>