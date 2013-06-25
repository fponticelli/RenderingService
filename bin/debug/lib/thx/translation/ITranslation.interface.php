<?php

interface thx_translation_ITranslation {
	function plural($ids, $idp, $quantifier, $domain = null);
	function singular($id, $domain = null);
}
