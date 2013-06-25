<?php

class ufront_web_mvc_DefaultModelBinder implements ufront_web_mvc_IModelBinder{
	public function __construct() { 
	}
	public function isSimpleType($typeName) {
		return ufront_web_mvc_ValueProviderResult::$jugglers->exists($typeName);
	}
	public function bindModel($controllerContext, $bindingContext) {
		$value = $bindingContext->valueProvider->getValue($bindingContext->modelName);
		$typeName = $bindingContext->modelType;
		if($value === null || _hx_field($value, "rawValue") === null) {
		}
		if($this->isSimpleType($typeName)) {
			if($value === null) {
				return null;
			}
			if(_hx_field($value, "rawValue") === null) {
				return $value->rawValue;
			}
			if($bindingContext->ctype !== null) {
				return ufront_web_mvc_ValueProviderResult::convertSimpleTypeRtti($value->attemptedValue, $bindingContext->ctype, false);
			} else {
				return ufront_web_mvc_ValueProviderResult::convertSimpleType($value->attemptedValue, $typeName);
			}
		}
		$enumType = Type::resolveEnum($typeName);
		if($enumType !== null) {
			return ufront_web_mvc_ValueProviderResult::convertEnum($value->attemptedValue, $enumType);
		}
		$classType = Type::resolveClass($typeName);
		if($classType === null) {
			throw new HException(new thx_error_Error("Could not bind to class " . _hx_string_or_null($typeName), null, null, _hx_anonymous(array("fileName" => "DefaultModelBinder.hx", "lineNumber" => 50, "className" => "ufront.web.mvc.DefaultModelBinder", "methodName" => "bindModel"))));
		}
		if(null !== $value && null !== _hx_field($value, "rawValue")) {
			try {
				$v = haxe_Unserializer::run($value->rawValue);
				if(Std::is($v, $classType)) {
					return $v;
				}
			}catch(Exception $__hx__e) {
				$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
				$e = $_ex_;
				{
				}
			}
		}
		if(!thx_type_Rttis::hasInfo($classType)) {
			return null;
		}
		$model = Type::createInstance($classType, new _hx_array(array()));
		$fields = thx_type_Rttis::getClassFields($classType);
		$__hx__it = call_user_func((ufront_web_mvc_DefaultModelBinder_0($this, $bindingContext, $classType, $controllerContext, $enumType, $f, $fields, $model, $typeName, $value)));
		while($__hx__it->hasNext()) {
			$f = $__hx__it->next();
			if(thx_type_Rttis::isMethod($f)) {
				continue;
			}
			$typeName1 = thx_type_Rttis::typeName($f->type, false);
			$context = new ufront_web_mvc_ModelBindingContext($f->name, $typeName1, $bindingContext->valueProvider, $f->type);
			$model->{$f->name} = $this->bindModel($controllerContext, $context);
			unset($typeName1,$context);
		}
		return $model;
	}
	function __toString() { return 'ufront.web.mvc.DefaultModelBinder'; }
}
function ufront_web_mvc_DefaultModelBinder_0(&$__hx__this, &$bindingContext, &$classType, &$controllerContext, &$enumType, &$f, &$fields, &$model, &$typeName, &$value) {
	{
		$_e = $fields;
		return array(new _hx_lambda(array(&$_e, &$bindingContext, &$classType, &$controllerContext, &$enumType, &$f, &$fields, &$model, &$typeName, &$value), "ufront_web_mvc_DefaultModelBinder_1"), 'execute');
	}
}
function ufront_web_mvc_DefaultModelBinder_1(&$_e, &$bindingContext, &$classType, &$controllerContext, &$enumType, &$f, &$fields, &$model, &$typeName, &$value) {
	{
		return $_e->iterator();
	}
}
