<?php

class hscript_Parser {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		$this->line = 1;
		$this->opChars = "+*/-=!><&|^%~";
		$this->identChars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789_";
		$priorities = new _hx_array(array(new _hx_array(array("%")), new _hx_array(array("*", "/")), new _hx_array(array("+", "-")), new _hx_array(array("<<", ">>", ">>>")), new _hx_array(array("|", "&", "^")), new _hx_array(array("==", "!=", ">", "<", ">=", "<=")), new _hx_array(array("...")), new _hx_array(array("&&")), new _hx_array(array("||")), new _hx_array(array("=", "+=", "-=", "*=", "/=", "%=", "<<=", ">>=", ">>>=", "|=", "&=", "^="))));
		$this->opPriority = new haxe_ds_StringMap();
		$this->opRightAssoc = new haxe_ds_StringMap();
		$this->unops = new haxe_ds_StringMap();
		{
			$_g1 = 0; $_g = $priorities->length;
			while($_g1 < $_g) {
				$i = $_g1++;
				$_g2 = 0; $_g3 = $priorities[$i];
				while($_g2 < $_g3->length) {
					$x = $_g3[$_g2];
					++$_g2;
					$this->opPriority->set($x, $i);
					if($i === 9) {
						$this->opRightAssoc->set($x, true);
					}
					unset($x);
				}
				unset($i,$_g3,$_g2);
			}
		}
		{
			$_g = 0; $_g1 = new _hx_array(array("!", "++", "--", "-", "~"));
			while($_g < $_g1->length) {
				$x = $_g1[$_g];
				++$_g;
				$this->unops->set($x, $x === "++" || $x === "--");
				unset($x);
			}
		}
	}}
	public function tokenString($t) {
		return hscript_Parser_0($this, $t);
	}
	public function constString($c) {
		return hscript_Parser_1($this, $c);
	}
	public function tokenComment($op, $char) {
		$c = _hx_char_code_at($op, 1);
		$s = $this->input;
		if($c === 47) {
			try {
				while($char !== 10 && $char !== 13) {
					$char = $s->readByte();
				}
				$this->char = $char;
			}catch(Exception $__hx__e) {
				$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
				$e = $_ex_;
				{
				}
			}
			return $this->token();
		}
		if($c === 42) {
			$old = $this->line;
			try {
				while(true) {
					while($char !== 42) {
						if($char === 10) {
							$this->line++;
						}
						$char = $s->readByte();
					}
					$char = $s->readByte();
					if($char === 47) {
						break;
					}
				}
			}catch(Exception $__hx__e) {
				$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
				$e = $_ex_;
				{
					$this->line = $old;
					throw new HException(hscript_Error::$EUnterminatedComment);
				}
			}
			return $this->token();
		}
		$this->char = $char;
		return hscript_Token::TOp($op);
	}
	public function token() {
		if(!($this->tokens->head === null)) {
			return hscript_Parser_2($this);
		}
		$char = null;
		if($this->char < 0) {
			$char = $this->readChar();
		} else {
			$char = $this->char;
			$this->char = -1;
		}
		while(true) {
			switch($char) {
			case 0:{
				return hscript_Token::$TEof;
			}break;
			case 32:case 9:case 13:{
			}break;
			case 10:{
				$this->line++;
			}break;
			case 48:case 49:case 50:case 51:case 52:case 53:case 54:case 55:case 56:case 57:{
				$n = ($char - 48) * 1.0;
				$exp = 0.;
				while(true) {
					$char = $this->readChar();
					$exp *= 10;
					switch($char) {
					case 48:case 49:case 50:case 51:case 52:case 53:case 54:case 55:case 56:case 57:{
						$n = $n * 10 + ($char - 48);
					}break;
					case 46:{
						if($exp > 0) {
							if(_hx_equal($exp, 10) && $this->readChar() === 46) {
								{
									$_this = $this->tokens;
									$_this->head = new haxe_ds_GenericCell(hscript_Token::TOp("..."), $_this->head);
								}
								$i = Std::int($n);
								return hscript_Token::TConst(((_hx_equal($i, $n)) ? hscript_Const::CInt($i) : hscript_Const::CFloat($n)));
							}
							$this->invalidChar($char);
						}
						$exp = 1.;
					}break;
					case 120:{
						if($n > 0 || $exp > 0) {
							$this->invalidChar($char);
						}
						$n1 = 0;
						while(true) {
							$char = $this->readChar();
							switch($char) {
							case 48:case 49:case 50:case 51:case 52:case 53:case 54:case 55:case 56:case 57:{
								$n1 = ($n1 << 4) + $char - 48;
							}break;
							case 65:case 66:case 67:case 68:case 69:case 70:{
								$n1 = ($n1 << 4) + ($char - 55);
							}break;
							case 97:case 98:case 99:case 100:case 101:case 102:{
								$n1 = ($n1 << 4) + ($char - 87);
							}break;
							default:{
								$this->char = $char;
								return hscript_Token::TConst(hscript_Const::CInt($n1));
							}break;
							}
						}
					}break;
					default:{
						$this->char = $char;
						$i = Std::int($n);
						return hscript_Token::TConst((($exp > 0) ? hscript_Const::CFloat($n * 10 / $exp) : ((_hx_equal($i, $n)) ? hscript_Const::CInt($i) : hscript_Const::CFloat($n))));
					}break;
					}
				}
			}break;
			case 59:{
				return hscript_Token::$TSemicolon;
			}break;
			case 40:{
				return hscript_Token::$TPOpen;
			}break;
			case 41:{
				return hscript_Token::$TPClose;
			}break;
			case 44:{
				return hscript_Token::$TComma;
			}break;
			case 46:{
				$char = $this->readChar();
				switch($char) {
				case 48:case 49:case 50:case 51:case 52:case 53:case 54:case 55:case 56:case 57:{
					$n = $char - 48;
					$exp = 1;
					while(true) {
						$char = $this->readChar();
						$exp *= 10;
						switch($char) {
						case 48:case 49:case 50:case 51:case 52:case 53:case 54:case 55:case 56:case 57:{
							$n = $n * 10 + ($char - 48);
						}break;
						default:{
							$this->char = $char;
							return hscript_Token::TConst(hscript_Const::CFloat($n / $exp));
						}break;
						}
					}
				}break;
				case 46:{
					$char = $this->readChar();
					if($char !== 46) {
						$this->invalidChar($char);
					}
					return hscript_Token::TOp("...");
				}break;
				default:{
					$this->char = $char;
					return hscript_Token::$TDot;
				}break;
				}
			}break;
			case 123:{
				return hscript_Token::$TBrOpen;
			}break;
			case 125:{
				return hscript_Token::$TBrClose;
			}break;
			case 91:{
				return hscript_Token::$TBkOpen;
			}break;
			case 93:{
				return hscript_Token::$TBkClose;
			}break;
			case 39:{
				return hscript_Token::TConst(hscript_Const::CString($this->readString(39)));
			}break;
			case 34:{
				return hscript_Token::TConst(hscript_Const::CString($this->readString(34)));
			}break;
			case 63:{
				return hscript_Token::$TQuestion;
			}break;
			case 58:{
				return hscript_Token::$TDoubleDot;
			}break;
			default:{
				if($this->ops[$char]) {
					$op = chr($char);
					while(true) {
						$char = $this->readChar();
						if(!$this->ops[$char]) {
							if(_hx_char_code_at($op, 0) === 47) {
								return $this->tokenComment($op, $char);
							}
							$this->char = $char;
							return hscript_Token::TOp($op);
						}
						$op .= _hx_string_or_null(chr($char));
					}
				}
				if($this->idents[$char]) {
					$id = chr($char);
					while(true) {
						$char = $this->readChar();
						if(!$this->idents[$char]) {
							$this->char = $char;
							return hscript_Token::TId($id);
						}
						$id .= _hx_string_or_null(chr($char));
					}
				}
				$this->invalidChar($char);
			}break;
			}
			$char = $this->readChar();
		}
		return null;
	}
	public function readString($until) {
		$c = 0;
		$b = new haxe_io_BytesOutput();
		$esc = false;
		$old = $this->line;
		$s = $this->input;
		while(true) {
			try {
				$c = $s->readByte();
			}catch(Exception $__hx__e) {
				$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
				$e = $_ex_;
				{
					$this->line = $old;
					throw new HException(hscript_Error::$EUnterminatedString);
				}
			}
			if($esc) {
				$esc = false;
				switch($c) {
				case 110:{
					$b->writeByte(10);
				}break;
				case 114:{
					$b->writeByte(13);
				}break;
				case 116:{
					$b->writeByte(9);
				}break;
				case 39:case 34:case 92:{
					$b->writeByte($c);
				}break;
				case 47:{
					if($this->allowJSON) {
						$b->writeByte($c);
					} else {
						$this->invalidChar($c);
					}
				}break;
				case 117:{
					if(!$this->allowJSON) {
						throw new HException($this->invalidChar($c));
					}
					$code = null;
					try {
						$code = $s->readString(4);
					}catch(Exception $__hx__e) {
						$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
						$e2 = $_ex_;
						{
							$this->line = $old;
							throw new HException(hscript_Error::$EUnterminatedString);
						}
					}
					$k = 0;
					{
						$_g = 0;
						while($_g < 4) {
							$i = $_g++;
							$k <<= 4;
							$char = _hx_char_code_at($code, $i);
							switch($char) {
							case 48:case 49:case 50:case 51:case 52:case 53:case 54:case 55:case 56:case 57:{
								$k += $char - 48;
							}break;
							case 65:case 66:case 67:case 68:case 69:case 70:{
								$k += $char - 55;
							}break;
							case 97:case 98:case 99:case 100:case 101:case 102:{
								$k += $char - 87;
							}break;
							default:{
								$this->invalidChar($char);
							}break;
							}
							unset($i,$char);
						}
					}
					if($k <= 127) {
						$b->writeByte($k);
					} else {
						if($k <= 2047) {
							$b->writeByte(192 | $k >> 6);
							$b->writeByte(128 | $k & 63);
						} else {
							$b->writeByte(224 | $k >> 12);
							$b->writeByte(128 | $k >> 6 & 63);
							$b->writeByte(128 | $k & 63);
						}
					}
				}break;
				default:{
					$this->invalidChar($c);
				}break;
				}
			} else {
				if($c === 92) {
					$esc = true;
				} else {
					if($c === $until) {
						break;
					} else {
						if($c === 10) {
							$this->line++;
						}
						$b->writeByte($c);
					}
				}
			}
			unset($e);
		}
		return $b->getBytes()->toString();
	}
	public function readChar() {
		return hscript_Parser_3($this);
	}
	public function incPos() {
	}
	public function parseExprList($etk) {
		$args = new _hx_array(array());
		$tk = $this->token();
		if($tk === $etk) {
			return $args;
		}
		{
			$_this = $this->tokens;
			$_this->head = new haxe_ds_GenericCell($tk, $_this->head);
		}
		while(true) {
			$args->push($this->parseExpr());
			$tk = $this->token();
			$__hx__t = ($tk);
			switch($__hx__t->index) {
			case 9:
			{
			}break;
			default:{
				if($tk === $etk) {
					break 2;
				}
				$this->unexpected($tk);
			}break;
			}
		}
		return $args;
	}
	public function parseTypeNext($t) {
		$tk = $this->token();
		$__hx__t = ($tk);
		switch($__hx__t->index) {
		case 3:
		$op = $__hx__t->params[0];
		{
			if($op !== "->") {
				{
					$_this = $this->tokens;
					$_this->head = new haxe_ds_GenericCell($tk, $_this->head);
				}
				return $t;
			}
		}break;
		default:{
			{
				$_this = $this->tokens;
				$_this->head = new haxe_ds_GenericCell($tk, $_this->head);
			}
			return $t;
		}break;
		}
		$t2 = $this->parseType();
		$__hx__t = ($t2);
		switch($__hx__t->index) {
		case 1:
		$t2_eCTFun_1 = $__hx__t->params[1]; $args = $__hx__t->params[0];
		{
			$args->unshift($t);
			return $t2;
		}break;
		default:{
			return hscript_CType::CTFun(new _hx_array(array($t)), $t2);
		}break;
		}
	}
	public function parseType() {
		$t = $this->token();
		$__hx__t = ($t);
		switch($__hx__t->index) {
		case 2:
		$v = $__hx__t->params[0];
		{
			$path = new _hx_array(array($v));
			while(true) {
				$t = $this->token();
				if($t !== hscript_Token::$TDot) {
					break;
				}
				$t = $this->token();
				$__hx__t2 = ($t);
				switch($__hx__t2->index) {
				case 2:
				$v1 = $__hx__t2->params[0];
				{
					$path->push($v1);
				}break;
				default:{
					$this->unexpected($t);
				}break;
				}
			}
			$params = null;
			$__hx__t2 = ($t);
			switch($__hx__t2->index) {
			case 3:
			$op = $__hx__t2->params[0];
			{
				if($op === "<") {
					$params = new _hx_array(array());
					while(true) {
						$params->push($this->parseType());
						$t = $this->token();
						$__hx__t3 = ($t);
						switch($__hx__t3->index) {
						case 9:
						{
							continue 2;
						}break;
						case 3:
						$op1 = $__hx__t3->params[0];
						{
							if($op1 === ">") {
								break 2;
							}
						}break;
						default:{
						}break;
						}
						$this->unexpected($t);
					}
				}
			}break;
			default:{
				$_this = $this->tokens;
				$_this->head = new haxe_ds_GenericCell($t, $_this->head);
			}break;
			}
			return $this->parseTypeNext(hscript_CType::CTPath($path, $params));
		}break;
		case 4:
		{
			$t1 = $this->parseType();
			{
				$t2 = $this->token();
				if($t2 !== hscript_Token::$TPClose) {
					$this->unexpected($t2);
				}
			}
			return $this->parseTypeNext(hscript_CType::CTParent($t1));
		}break;
		case 6:
		{
			$fields = new _hx_array(array());
			while(true) {
				$t = $this->token();
				$__hx__t2 = ($t);
				switch($__hx__t2->index) {
				case 7:
				{
					break 2;
				}break;
				case 2:
				$name = $__hx__t2->params[0];
				{
					{
						$t1 = $this->token();
						if($t1 !== hscript_Token::$TDoubleDot) {
							$this->unexpected($t1);
						}
					}
					$fields->push(_hx_anonymous(array("name" => $name, "t" => $this->parseType())));
					$t = $this->token();
					$__hx__t3 = ($t);
					switch($__hx__t3->index) {
					case 9:
					{
					}break;
					case 7:
					{
						break 3;
					}break;
					default:{
						$this->unexpected($t);
					}break;
					}
				}break;
				default:{
					$this->unexpected($t);
				}break;
				}
			}
			return $this->parseTypeNext(hscript_CType::CTAnon($fields));
		}break;
		default:{
			return $this->unexpected($t);
		}break;
		}
	}
	public function parseExprNext($e1) {
		$tk = $this->token();
		$__hx__t = ($tk);
		switch($__hx__t->index) {
		case 3:
		$op = $__hx__t->params[0];
		{
			if($this->unops->get($op)) {
				if($this->isBlock($e1) || hscript_Parser_4($this, $e1, $op, $tk)) {
					{
						$_this = $this->tokens;
						$_this->head = new haxe_ds_GenericCell($tk, $_this->head);
					}
					return $e1;
				}
				return $this->parseExprNext(hscript_Expr::EUnop($op, false, $e1));
			}
			return $this->makeBinop($op, $e1, $this->parseExpr());
		}break;
		case 8:
		{
			$tk = $this->token();
			$field = null;
			$__hx__t2 = ($tk);
			switch($__hx__t2->index) {
			case 2:
			$id = $__hx__t2->params[0];
			{
				$field = $id;
			}break;
			default:{
				$this->unexpected($tk);
			}break;
			}
			return $this->parseExprNext(hscript_Expr::EField($e1, $field));
		}break;
		case 4:
		{
			return $this->parseExprNext(hscript_Expr::ECall($e1, $this->parseExprList(hscript_Token::$TPClose)));
		}break;
		case 11:
		{
			$e2 = $this->parseExpr();
			{
				$t = $this->token();
				if($t !== hscript_Token::$TBkClose) {
					$this->unexpected($t);
				}
			}
			return $this->parseExprNext(hscript_Expr::EArray($e1, $e2));
		}break;
		case 13:
		{
			$e2 = $this->parseExpr();
			{
				$t = $this->token();
				if($t !== hscript_Token::$TDoubleDot) {
					$this->unexpected($t);
				}
			}
			$e3 = $this->parseExpr();
			return hscript_Expr::ETernary($e1, $e2, $e3);
		}break;
		default:{
			{
				$_this = $this->tokens;
				$_this->head = new haxe_ds_GenericCell($tk, $_this->head);
			}
			return $e1;
		}break;
		}
	}
	public function parseStructure($id) {
		return hscript_Parser_5($this, $id);
	}
	public function makeBinop($op, $e1, $e) {
		return hscript_Parser_6($this, $e, $e1, $op);
	}
	public function makeUnop($op, $e) {
		return hscript_Parser_7($this, $e, $op);
	}
	public function parseExpr() {
		$tk = $this->token();
		$__hx__t = ($tk);
		switch($__hx__t->index) {
		case 2:
		$id = $__hx__t->params[0];
		{
			$e = $this->parseStructure($id);
			if($e === null) {
				$e = hscript_Expr::EIdent($id);
			}
			return $this->parseExprNext($e);
		}break;
		case 1:
		$c = $__hx__t->params[0];
		{
			return $this->parseExprNext(hscript_Expr::EConst($c));
		}break;
		case 4:
		{
			$e = $this->parseExpr();
			{
				$t = $this->token();
				if($t !== hscript_Token::$TPClose) {
					$this->unexpected($t);
				}
			}
			return $this->parseExprNext(hscript_Expr::EParent($e));
		}break;
		case 6:
		{
			$tk = $this->token();
			$__hx__t2 = ($tk);
			switch($__hx__t2->index) {
			case 7:
			{
				return $this->parseExprNext(hscript_Expr::EObject(new _hx_array(array())));
			}break;
			case 2:
			{
				$tk2 = $this->token();
				{
					$_this = $this->tokens;
					$_this->head = new haxe_ds_GenericCell($tk2, $_this->head);
				}
				{
					$_this = $this->tokens;
					$_this->head = new haxe_ds_GenericCell($tk, $_this->head);
				}
				$__hx__t3 = ($tk2);
				switch($__hx__t3->index) {
				case 14:
				{
					return $this->parseExprNext($this->parseObject(0));
				}break;
				default:{
				}break;
				}
			}break;
			case 1:
			$c = $__hx__t2->params[0];
			{
				if($this->allowJSON) {
					$__hx__t3 = ($c);
					switch($__hx__t3->index) {
					case 2:
					{
						$tk2 = $this->token();
						{
							$_this = $this->tokens;
							$_this->head = new haxe_ds_GenericCell($tk2, $_this->head);
						}
						{
							$_this = $this->tokens;
							$_this->head = new haxe_ds_GenericCell($tk, $_this->head);
						}
						$__hx__t4 = ($tk2);
						switch($__hx__t4->index) {
						case 14:
						{
							return $this->parseExprNext($this->parseObject(0));
						}break;
						default:{
						}break;
						}
					}break;
					default:{
						$_this = $this->tokens;
						$_this->head = new haxe_ds_GenericCell($tk, $_this->head);
					}break;
					}
				} else {
					$_this = $this->tokens;
					$_this->head = new haxe_ds_GenericCell($tk, $_this->head);
				}
			}break;
			default:{
				$_this = $this->tokens;
				$_this->head = new haxe_ds_GenericCell($tk, $_this->head);
			}break;
			}
			$a = new _hx_array(array());
			while(true) {
				$a->push($this->parseFullExpr());
				$tk = $this->token();
				if($tk === hscript_Token::$TBrClose) {
					break;
				}
				{
					$_this = $this->tokens;
					$_this->head = new haxe_ds_GenericCell($tk, $_this->head);
					unset($_this);
				}
			}
			return hscript_Expr::EBlock($a);
		}break;
		case 3:
		$op = $__hx__t->params[0];
		{
			if($this->unops->exists($op)) {
				return $this->makeUnop($op, $this->parseExpr());
			}
			return $this->unexpected($tk);
		}break;
		case 11:
		{
			$a = new _hx_array(array());
			$tk = $this->token();
			while($tk !== hscript_Token::$TBkClose) {
				{
					$_this = $this->tokens;
					$_this->head = new haxe_ds_GenericCell($tk, $_this->head);
					unset($_this);
				}
				$a->push($this->parseExpr());
				$tk = $this->token();
				if($tk === hscript_Token::$TComma) {
					$tk = $this->token();
				}
			}
			return $this->parseExprNext(hscript_Expr::EArrayDecl($a));
		}break;
		default:{
			return $this->unexpected($tk);
		}break;
		}
	}
	public function parseObject($p1) {
		$fl = new _hx_array(array());
		while(true) {
			$tk = $this->token();
			$id = null;
			$__hx__t = ($tk);
			switch($__hx__t->index) {
			case 2:
			$i = $__hx__t->params[0];
			{
				$id = $i;
			}break;
			case 1:
			$c = $__hx__t->params[0];
			{
				if(!$this->allowJSON) {
					$this->unexpected($tk);
				}
				$__hx__t2 = ($c);
				switch($__hx__t2->index) {
				case 2:
				$s = $__hx__t2->params[0];
				{
					$id = $s;
				}break;
				default:{
					$this->unexpected($tk);
				}break;
				}
			}break;
			case 7:
			{
				break 2;
			}break;
			default:{
				$this->unexpected($tk);
			}break;
			}
			{
				$t = $this->token();
				if($t !== hscript_Token::$TDoubleDot) {
					$this->unexpected($t);
				}
				unset($t);
			}
			$fl->push(_hx_anonymous(array("name" => $id, "e" => $this->parseExpr())));
			$tk = $this->token();
			$__hx__t = ($tk);
			switch($__hx__t->index) {
			case 7:
			{
				break 2;
			}break;
			case 9:
			{
			}break;
			default:{
				$this->unexpected($tk);
			}break;
			}
			unset($tk,$id);
		}
		return $this->parseExprNext(hscript_Expr::EObject($fl));
	}
	public function parseFullExpr() {
		$e = $this->parseExpr();
		$tk = $this->token();
		if($tk !== hscript_Token::$TSemicolon && $tk !== hscript_Token::$TEof) {
			if($this->isBlock($e)) {
				$_this = $this->tokens;
				$_this->head = new haxe_ds_GenericCell($tk, $_this->head);
			} else {
				$this->unexpected($tk);
			}
		}
		return $e;
	}
	public function isBlock($e) {
		return hscript_Parser_8($this, $e);
	}
	public function mk($e, $pmin = null, $pmax = null) {
		return $e;
	}
	public function pmax($e) {
		return 0;
	}
	public function pmin($e) {
		return 0;
	}
	public function expr($e) {
		return $e;
	}
	public function ensure($tk) {
		$t = $this->token();
		if($t !== $tk) {
			$this->unexpected($t);
		}
	}
	public function push($tk) {
		$_this = $this->tokens;
		$_this->head = new haxe_ds_GenericCell($tk, $_this->head);
	}
	public function unexpected($tk) {
		throw new HException(hscript_Error::EUnexpected($this->tokenString($tk)));
		return null;
	}
	public function parse($s) {
		$this->tokens = new haxe_ds_GenericStack();
		$this->char = -1;
		$this->input = $s;
		$this->ops = new _hx_array(array());
		$this->idents = new _hx_array(array());
		{
			$_g1 = 0; $_g = strlen($this->opChars);
			while($_g1 < $_g) {
				$i = $_g1++;
				$this->ops[_hx_char_code_at($this->opChars, $i)] = true;
				unset($i);
			}
		}
		{
			$_g1 = 0; $_g = strlen($this->identChars);
			while($_g1 < $_g) {
				$i = $_g1++;
				$this->idents[_hx_char_code_at($this->identChars, $i)] = true;
				unset($i);
			}
		}
		$a = new _hx_array(array());
		while(true) {
			$tk = $this->token();
			if($tk === hscript_Token::$TEof) {
				break;
			}
			{
				$_this = $this->tokens;
				$_this->head = new haxe_ds_GenericCell($tk, $_this->head);
				unset($_this);
			}
			$a->push($this->parseFullExpr());
			unset($tk);
		}
		return hscript_Parser_9($this, $a, $s);
	}
	public function parseString($s) {
		$this->line = 1;
		return $this->parse(new haxe_io_StringInput($s));
	}
	public function invalidChar($c) {
		throw new HException(hscript_Error::EInvalidChar($c));
	}
	public function error($err, $pmin, $pmax) {
		throw new HException($err);
	}
	public $tokens;
	public $idents;
	public $ops;
	public $char;
	public $input;
	public $allowTypes;
	public $allowJSON;
	public $unops;
	public $opRightAssoc;
	public $opPriority;
	public $identChars;
	public $opChars;
	public $line;
	public function __call($m, $a) {
		if(isset($this->$m) && is_callable($this->$m))
			return call_user_func_array($this->$m, $a);
		else if(isset($this->__dynamics[$m]) && is_callable($this->__dynamics[$m]))
			return call_user_func_array($this->__dynamics[$m], $a);
		else if('toString' == $m)
			return $this->__toString();
		else
			throw new HException('Unable to call <'.$m.'>');
	}
	function __toString() { return 'hscript.Parser'; }
}
function hscript_Parser_0(&$__hx__this, &$t) {
	$__hx__t = ($t);
	switch($__hx__t->index) {
	case 0:
	{
		return "<eof>";
	}break;
	case 1:
	$c = $__hx__t->params[0];
	{
		return $__hx__this->constString($c);
	}break;
	case 2:
	$s = $__hx__t->params[0];
	{
		return $s;
	}break;
	case 3:
	$s = $__hx__t->params[0];
	{
		return $s;
	}break;
	case 4:
	{
		return "(";
	}break;
	case 5:
	{
		return ")";
	}break;
	case 6:
	{
		return "{";
	}break;
	case 7:
	{
		return "}";
	}break;
	case 8:
	{
		return ".";
	}break;
	case 9:
	{
		return ",";
	}break;
	case 10:
	{
		return ";";
	}break;
	case 11:
	{
		return "[";
	}break;
	case 12:
	{
		return "]";
	}break;
	case 13:
	{
		return "?";
	}break;
	case 14:
	{
		return ":";
	}break;
	}
}
function hscript_Parser_1(&$__hx__this, &$c) {
	$__hx__t = ($c);
	switch($__hx__t->index) {
	case 0:
	$v = $__hx__t->params[0];
	{
		return Std::string($v);
	}break;
	case 1:
	$f = $__hx__t->params[0];
	{
		return Std::string($f);
	}break;
	case 2:
	$s = $__hx__t->params[0];
	{
		return $s;
	}break;
	}
}
function hscript_Parser_2(&$__hx__this) {
	{
		$_this = $__hx__this->tokens;
		$k = $_this->head;
		if($k === null) {
			return null;
		} else {
			$_this->head = $k->next;
			return $k->elt;
		}
		unset($k,$_this);
	}
}
function hscript_Parser_3(&$__hx__this) {
	try {
		return $__hx__this->input->readByte();
	}catch(Exception $__hx__e) {
		$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
		$e = $_ex_;
		{
			return 0;
		}
	}
}
function hscript_Parser_4(&$__hx__this, &$e1, &$op, &$tk) {
	$__hx__t2 = ($e1);
	switch($__hx__t2->index) {
	case 3:
	{
		return true;
	}break;
	default:{
		return false;
	}break;
	}
}
function hscript_Parser_5(&$__hx__this, &$id) {
	switch($id) {
	case "if":{
		$cond = $__hx__this->parseExpr();
		$e1 = $__hx__this->parseExpr();
		$e2 = null;
		$semic = false;
		$tk = $__hx__this->token();
		if($tk === hscript_Token::$TSemicolon) {
			$semic = true;
			$tk = $__hx__this->token();
		}
		if(Type::enumEq($tk, hscript_Token::TId("else"))) {
			$e2 = $__hx__this->parseExpr();
		} else {
			{
				$_this = $__hx__this->tokens;
				$_this->head = new haxe_ds_GenericCell($tk, $_this->head);
			}
			if($semic) {
				$_this = $__hx__this->tokens;
				$_this->head = new haxe_ds_GenericCell(hscript_Token::$TSemicolon, $_this->head);
			}
		}
		return hscript_Expr::EIf($cond, $e1, $e2);
	}break;
	case "var":{
		$tk = $__hx__this->token();
		$ident = null;
		$__hx__t = ($tk);
		switch($__hx__t->index) {
		case 2:
		$id1 = $__hx__t->params[0];
		{
			$ident = $id1;
		}break;
		default:{
			$__hx__this->unexpected($tk);
		}break;
		}
		$tk = $__hx__this->token();
		$t = null;
		if($tk === hscript_Token::$TDoubleDot && $__hx__this->allowTypes) {
			$t = $__hx__this->parseType();
			$tk = $__hx__this->token();
		}
		$e = null;
		if(Type::enumEq($tk, hscript_Token::TOp("="))) {
			$e = $__hx__this->parseExpr();
		} else {
			$_this = $__hx__this->tokens;
			$_this->head = new haxe_ds_GenericCell($tk, $_this->head);
		}
		return hscript_Expr::EVar($ident, $t, $e);
	}break;
	case "while":{
		$econd = $__hx__this->parseExpr();
		$e = $__hx__this->parseExpr();
		return hscript_Expr::EWhile($econd, $e);
	}break;
	case "for":{
		{
			$t = $__hx__this->token();
			if($t !== hscript_Token::$TPOpen) {
				$__hx__this->unexpected($t);
			}
		}
		$tk = $__hx__this->token();
		$vname = null;
		$__hx__t = ($tk);
		switch($__hx__t->index) {
		case 2:
		$id1 = $__hx__t->params[0];
		{
			$vname = $id1;
		}break;
		default:{
			$__hx__this->unexpected($tk);
		}break;
		}
		$tk = $__hx__this->token();
		if(!Type::enumEq($tk, hscript_Token::TId("in"))) {
			$__hx__this->unexpected($tk);
		}
		$eiter = $__hx__this->parseExpr();
		{
			$t = $__hx__this->token();
			if($t !== hscript_Token::$TPClose) {
				$__hx__this->unexpected($t);
			}
		}
		$e = $__hx__this->parseExpr();
		return hscript_Expr::EFor($vname, $eiter, $e);
	}break;
	case "break":{
		return hscript_Expr::$EBreak;
	}break;
	case "continue":{
		return hscript_Expr::$EContinue;
	}break;
	case "else":{
		return $__hx__this->unexpected(hscript_Token::TId($id));
	}break;
	case "function":{
		$tk = $__hx__this->token();
		$name = null;
		$__hx__t = ($tk);
		switch($__hx__t->index) {
		case 2:
		$id1 = $__hx__t->params[0];
		{
			$name = $id1;
		}break;
		default:{
			$_this = $__hx__this->tokens;
			$_this->head = new haxe_ds_GenericCell($tk, $_this->head);
		}break;
		}
		{
			$t = $__hx__this->token();
			if($t !== hscript_Token::$TPOpen) {
				$__hx__this->unexpected($t);
			}
		}
		$args = new _hx_array(array());
		$tk = $__hx__this->token();
		if($tk !== hscript_Token::$TPClose) {
			$arg = true;
			while($arg) {
				$name1 = null;
				$__hx__t = ($tk);
				switch($__hx__t->index) {
				case 2:
				$id1 = $__hx__t->params[0];
				{
					$name1 = $id1;
				}break;
				default:{
					$__hx__this->unexpected($tk);
				}break;
				}
				$tk = $__hx__this->token();
				$t = null;
				if($tk === hscript_Token::$TDoubleDot && $__hx__this->allowTypes) {
					$t = $__hx__this->parseType();
					$tk = $__hx__this->token();
				}
				$args->push(_hx_anonymous(array("name" => $name1, "t" => $t)));
				$__hx__t = ($tk);
				switch($__hx__t->index) {
				case 9:
				{
					$tk = $__hx__this->token();
				}break;
				case 5:
				{
					$arg = false;
				}break;
				default:{
					$__hx__this->unexpected($tk);
				}break;
				}
				unset($t,$name1);
			}
		}
		$ret = null;
		if($__hx__this->allowTypes) {
			$tk = $__hx__this->token();
			if($tk !== hscript_Token::$TDoubleDot) {
				$_this = $__hx__this->tokens;
				$_this->head = new haxe_ds_GenericCell($tk, $_this->head);
			} else {
				$ret = $__hx__this->parseType();
			}
		}
		$body = $__hx__this->parseExpr();
		return hscript_Expr::EFunction($args, $body, $name, $ret);
	}break;
	case "return":{
		$tk = $__hx__this->token();
		{
			$_this = $__hx__this->tokens;
			$_this->head = new haxe_ds_GenericCell($tk, $_this->head);
		}
		$e = (($tk === hscript_Token::$TSemicolon) ? null : $__hx__this->parseExpr());
		return hscript_Expr::EReturn($e);
	}break;
	case "new":{
		$a = new _hx_array(array());
		$tk = $__hx__this->token();
		$__hx__t = ($tk);
		switch($__hx__t->index) {
		case 2:
		$id1 = $__hx__t->params[0];
		{
			$a->push($id1);
		}break;
		default:{
			$__hx__this->unexpected($tk);
		}break;
		}
		$next = true;
		while($next) {
			$tk = $__hx__this->token();
			$__hx__t = ($tk);
			switch($__hx__t->index) {
			case 8:
			{
				$tk = $__hx__this->token();
				$__hx__t2 = ($tk);
				switch($__hx__t2->index) {
				case 2:
				$id1 = $__hx__t2->params[0];
				{
					$a->push($id1);
				}break;
				default:{
					$__hx__this->unexpected($tk);
				}break;
				}
			}break;
			case 4:
			{
				$next = false;
			}break;
			default:{
				$__hx__this->unexpected($tk);
			}break;
			}
		}
		$args = $__hx__this->parseExprList(hscript_Token::$TPClose);
		return hscript_Expr::ENew($a->join("."), $args);
	}break;
	case "throw":{
		$e = $__hx__this->parseExpr();
		return hscript_Expr::EThrow($e);
	}break;
	case "try":{
		$e = $__hx__this->parseExpr();
		$tk = $__hx__this->token();
		if(!Type::enumEq($tk, hscript_Token::TId("catch"))) {
			$__hx__this->unexpected($tk);
		}
		{
			$t = $__hx__this->token();
			if($t !== hscript_Token::$TPOpen) {
				$__hx__this->unexpected($t);
			}
		}
		$tk = $__hx__this->token();
		$vname = hscript_Parser_10($e, $id, $tk);
		{
			$t = $__hx__this->token();
			if($t !== hscript_Token::$TDoubleDot) {
				$__hx__this->unexpected($t);
			}
		}
		$t = null;
		if($__hx__this->allowTypes) {
			$t = $__hx__this->parseType();
		} else {
			$tk = $__hx__this->token();
			if(!Type::enumEq($tk, hscript_Token::TId("Dynamic"))) {
				$__hx__this->unexpected($tk);
			}
		}
		{
			$t1 = $__hx__this->token();
			if($t1 !== hscript_Token::$TPClose) {
				$__hx__this->unexpected($t1);
			}
		}
		$ec = $__hx__this->parseExpr();
		return hscript_Expr::ETry($e, $vname, $t, $ec);
	}break;
	default:{
		return null;
	}break;
	}
}
function hscript_Parser_6(&$__hx__this, &$e, &$e1, &$op) {
	$__hx__t = ($e);
	switch($__hx__t->index) {
	case 6:
	$e3 = $__hx__t->params[2]; $e2 = $__hx__t->params[1]; $op2 = $__hx__t->params[0];
	{
		if($__hx__this->opPriority->get($op) <= $__hx__this->opPriority->get($op2) && !$__hx__this->opRightAssoc->exists($op)) {
			return hscript_Expr::EBinop($op2, $__hx__this->makeBinop($op, $e1, $e2), $e3);
		} else {
			return hscript_Expr::EBinop($op, $e1, $e);
		}
	}break;
	case 22:
	$e4 = $__hx__t->params[2]; $e3 = $__hx__t->params[1]; $e2 = $__hx__t->params[0];
	{
		if($__hx__this->opRightAssoc->exists($op)) {
			return hscript_Expr::EBinop($op, $e1, $e);
		} else {
			return hscript_Expr::ETernary($__hx__this->makeBinop($op, $e1, $e2), $e3, $e4);
		}
	}break;
	default:{
		return hscript_Expr::EBinop($op, $e1, $e);
	}break;
	}
}
function hscript_Parser_7(&$__hx__this, &$e, &$op) {
	$__hx__t = ($e);
	switch($__hx__t->index) {
	case 6:
	$e2 = $__hx__t->params[2]; $e1 = $__hx__t->params[1]; $bop = $__hx__t->params[0];
	{
		return hscript_Expr::EBinop($bop, $__hx__this->makeUnop($op, $e1), $e2);
	}break;
	case 22:
	$e3 = $__hx__t->params[2]; $e2 = $__hx__t->params[1]; $e1 = $__hx__t->params[0];
	{
		return hscript_Expr::ETernary($__hx__this->makeUnop($op, $e1), $e2, $e3);
	}break;
	default:{
		return hscript_Expr::EUnop($op, true, $e);
	}break;
	}
}
function hscript_Parser_8(&$__hx__this, &$e) {
	$__hx__t = ($e);
	switch($__hx__t->index) {
	case 4:
	case 21:
	{
		return true;
	}break;
	case 14:
	$e_eEFunction_3 = $__hx__t->params[3]; $e_eEFunction_2 = $__hx__t->params[2]; $e1 = $__hx__t->params[1]; $e_eEFunction_0 = $__hx__t->params[0];
	{
		return $__hx__this->isBlock($e1);
	}break;
	case 2:
	$e1 = $__hx__t->params[2]; $e_eEVar_1 = $__hx__t->params[1]; $e_eEVar_0 = $__hx__t->params[0];
	{
		return $e1 !== null && $__hx__this->isBlock($e1);
	}break;
	case 9:
	$e2 = $__hx__t->params[2]; $e1 = $__hx__t->params[1]; $e_eEIf_0 = $__hx__t->params[0];
	{
		if($e2 !== null) {
			return $__hx__this->isBlock($e2);
		} else {
			return $__hx__this->isBlock($e1);
		}
	}break;
	case 6:
	$e1 = $__hx__t->params[2]; $e_eEBinop_1 = $__hx__t->params[1]; $e_eEBinop_0 = $__hx__t->params[0];
	{
		return $__hx__this->isBlock($e1);
	}break;
	case 7:
	$e1 = $__hx__t->params[2]; $prefix = $__hx__t->params[1]; $e_eEUnop_0 = $__hx__t->params[0];
	{
		return !$prefix && $__hx__this->isBlock($e1);
	}break;
	case 10:
	$e1 = $__hx__t->params[1]; $e_eEWhile_0 = $__hx__t->params[0];
	{
		return $__hx__this->isBlock($e1);
	}break;
	case 11:
	$e1 = $__hx__t->params[2]; $e_eEFor_1 = $__hx__t->params[1]; $e_eEFor_0 = $__hx__t->params[0];
	{
		return $__hx__this->isBlock($e1);
	}break;
	case 15:
	$e1 = $__hx__t->params[0];
	{
		return $e1 !== null && $__hx__this->isBlock($e1);
	}break;
	default:{
		return false;
	}break;
	}
}
function hscript_Parser_9(&$__hx__this, &$a, &$s) {
	if($a->length === 1) {
		return $a[0];
	} else {
		return hscript_Expr::EBlock($a);
	}
}
function hscript_Parser_10(&$e, &$id, &$tk) {
	$__hx__t = ($tk);
	switch($__hx__t->index) {
	case 2:
	$id1 = $__hx__t->params[0];
	{
		return $id1;
	}break;
	default:{
		return $__hx__this->unexpected($tk);
	}break;
	}
}
