<?php
/**
 * Created by PhpStorm.
 * User: liupf
 * Date: 17-9-7
 * Time: 下午4:29
 */

namespace helpers;


class CValidator {
    /**
     * The data under validation.
     *
     * @var array
     */
    protected  $data;

    /**
     * The initial rules provided.
     *
     * @var array
     */
    protected  $initialRules;

    /**
     * The rules to be applied to the data.
     *
     * @var array
     */
    protected   $rules;
    /**
     * The rules can be applied to the data.
     *
     * @var array
     */
    protected  $mergeRules;

    /**
     * The array of custom error messages.
     *
     * @var array
     */
    protected   $errors = [];



    /**
     * The validation rules that imply the field is required.
     *
     * @var array
     */
    protected $implicitRules = [
        'Required'
    ];

    /**
     * The size related validation rules.
     *
     * @var array
     */
    protected $sizeRules = ['Size', 'Between', 'Min', 'Max'];

    /**
     * The numeric related validation rules.
     *
     * @var array
     */
    protected $numericRules = ['Numeric', 'Integer'];

    /**
     *  The following language lines contain the default error messages used by
     * the validator class. Some of these rules have multiple versions such
     * as the size rules. Feel free to tweak each of these messages here.
     *
     * @var array
     */
    protected $errorMessages = [
        'rule_not_exist'       => 'The :rule rule isn\'t exist.',
        'between'              => [
            'numeric' => 'The :attribute must be between :min and :max.',
            'file'    => 'The :attribute must be between :min and :max kilobytes.',
            'string'  => 'The :attribute must be between :min and :max characters.',
            'array'   => 'The :attribute must have between :min and :max items.',
        ],
        'boolean'              => 'The :attribute field must be true or false.',
        'date'                 => 'The :attribute is not a valid date.',
        'email'                => 'The :attribute must be a valid email address.',
        'exists'               => 'The selected :attribute is invalid.',
        'image'                => 'The :attribute must be an image.',
        'in'                   => 'The selected :attribute is invalid.',
        'integer'              => 'The :attribute must be an integer.',
        'max'                  => [
            'numeric' => 'The :attribute may not be greater than :max.',
            'file'    => 'The :attribute may not be greater than :max kilobytes.',
            'string'  => 'The :attribute may not be greater than :max characters.',
            'array'   => 'The :attribute may not have more than :max items.',
        ],
        'min'                  => [
            'numeric' => 'The :attribute must be at least :min.',
            'file'    => 'The :attribute must be at least :min kilobytes.',
            'string'  => 'The :attribute must be at least :min characters.',
            'array'   => 'The :attribute must have at least :min items.',
        ],
        'not_in'               => 'The selected :attribute is invalid.',
        'numeric'              => 'The :attribute must be a number.',
        'required'             => 'The :attribute field is required.',
        'size'                 => [
            'numeric' => 'The :attribute must be :size.',
            'file'    => 'The :attribute must be :size kilobytes.',
            'string'  => 'The :attribute must be :size characters.',
            'array'   => 'The :attribute must contain :size items.',
        ],
        'string'               => 'The :attribute must be a string.',
        'url'                  => 'The :attribute format is invalid.',
    ];


    public function __construct(array $data, array $rules)
    {
        $this->initialRules = $rules;
        $this->data = $data;
        $this->parseRules();
        $this->mergeRules();
        $this->validate();
    }

    protected function validate(){
        foreach($this->$rules as $attribute => $rules){
              $this->validateAttribute($attribute, $rules);
        }
    }

    protected function validateAttribute($attribute,$rules){
        foreach($rules as $rule){
            if($this->shouldStopValidating($attribute,$rule)){
                break;
            }
        }
    }

    protected function shouldStopValidating($attribute,$rule){
        if( ! $this->hasRule($rule[0]) ){
            $message = $this->errorMessages['rule_not_exist'];
            $this->errors[] = preg_replace(':rule',$rule[0],$message);
            return false;
        }
        if( ! $this->checkParameters($rule[0],$rule[1]) ){
            $type = $this->getAttributeType($attribute);
            $message = $this->errorMessages[$rule[0]][$type];
            $message = preg_replace(':attribute',$attribute,$message);
            $this->errors[] = $this->replaceParameters($message,$rule[1]);
        }

    }

    protected function checkParameters($rule,$parameters){
        switch($rule){
            case 'Between':
                return (count($parameters) == 2) ? true : false;
            case 'Max':
            case 'Min':
            case 'Size':
                return (count($parameters) == 1) ? true : false;
            default:
                return true;
        }
    }

    protected function replaceParameters($message,$parameters){
        switch($rule){
            case 'Between':
                return (count($parameters) == 2) ? true : false;
            case 'Max':
            case 'Min':
            case 'Size':
                return (count($parameters) == 1) ? true : false;
            default:
                return true;
        }
    }

    protected function mergeRules(){
        $this->mergeRules =  array_merge($this->implicitRules,$this->sizeRules,$this->numericRules);
    }

    protected function hasRule($rule){
       return in_array($rule,$this->mergeRules);
    }

    protected function parseRules(){
        foreach($this->initialRules as $attribute => $stringRule){
            $rules = explode('|',$stringRule);
            foreach($rules as $rule){
                $this->rules[$attribute][] = $this->parseStringRule($rule);
            }
        }
    }

    protected function parseStringRule($stringRule){
        $parameters = [];

        if (strpos($stringRule, ':') !== false) {
            list($rule, $parameter) = explode(':', $stringRule, 2);
            $rule = ucfirst($rule);
            $parameters = $this->parseParameters($rule, $parameter);
        }

        return [$rule,$parameters];
    }

    protected function parseParameters($rule, $parameter){
        if($rule == 'Between'){
            $parameter = explode(',',$parameter,2);
        }
        return $rule == 'Between' ? explode(',',$parameter,2) :[$parameter];
    }

    /**
     * Get the data type of the given attribute.
     *
     * @param  string  $attribute
     * @return string
     */
    protected function getAttributeType($attribute)
    {
        if ($this->hasDependRule($attribute, $this->numericRules)) {
            return 'numeric';
        } elseif ($this->hasDependRule($attribute, ['Array'])) {
            return 'array';
        }

        return 'string';
    }

    protected function hasDependRule($attribute,$rules){
        foreach( $this->rules[$attribute] as $rule){
            if( in_array($rule[0],$rules)){
                return true;
            }
        }
        return false;
    }

    protected function getRules($attribute){
        $rules = [];
        foreach( $this->rules[$attribute] as $rule){
            $rules[] = $rule[0];
        }
        return $rules;
    }
}