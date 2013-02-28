<?php

namespace Access\Utils;

use DateTime;

class Utils
{
    public static function generatePassword($length=12, $strength=0)
    {
        $vowels = 'aeuy';
        $consonants = 'bdghjmnpqrstvz';
        if ($strength & 1) {
            $consonants .= 'BDGHJLMNPQRSTVWXZ';
        }
        if ($strength & 2) {
            $vowels .= "AEUY";
        }
        if ($strength & 4) {
            $consonants .= '23456789';
        }
        if ($strength & 8) {
            $consonants .= '@#$%';
        }

        $password = '';
        $alt = time() % 2;
        for ($i = 0; $i < $length; $i++) {
            if ($alt == 1) {
                $password .= $consonants[(rand() % strlen($consonants))];
                $alt = 0;
            } else {
                $password .= $vowels[(rand() % strlen($vowels))];
                $alt = 1;
            }
        }
        return $password;
    }

    public static function detachObjectsFromMultiselect($object, $methodToArray)
    {
        $return = array($object);

        if(method_exists($object, $methodToArray))
        {
            $return = array();

            $array = $object->$methodToArray();
            foreach($array as $item)
            {
                $className = get_class($object);
                $obj = new $className();

                $setMethod = "set" . substr($methodToArray, 3, strlen($methodToArray)-3);

                $obj->$setMethod($item);

                $return[] = $obj;
            }
        }

        return $return;
    }

    /**
    * @recursively check if a value is in array
    * @param string $string (needle)
    * @param array $array (haystack)
    * @param bool $type (optional)
    * @return bool
    */
    public static function in_array_recursive($string, $array, $type=false)
    {
        /*** an recursive iterator object ***/
        $it = new RecursiveIteratorIterator(new RecursiveArrayIterator($array));

        /*** traverse the $iterator object ***/
        while($it->valid())
        {
            /*** check for a match ***/
            if( $type === false )
            {
                if( $it->current() == $string )
                {
                    return true;
                }
            }
            else
            {
                if( $it->current() === $string )
                {
                    return true;
                }
            }
            $it->next();
        }
        /*** if no match is found ***/
        return false;
    }

    public static function RemoveAcentos($str)
    {
        $str = strtr($str, 'áéíóúàèìòùãõâêîôôäëïöüÁÉÍÓÚÀÈÌÒÙÃÕÂÊÎÔÛÄËÏÖÜ', 'aeiouaeiouaoaeiooaeiouAEIOUAEIOUAOAEIOOAEIOU');

        return $str;
    }
    
    /**
    * Converte data do formato dd/mm/aaaa para aaaa-mm-dd
    */
    public static function DateToBd($data) {
        if (!$data) {
            return NULL;
        } else {
            $fragments = explode("/", $data);
            $formatted_date = $fragments[2] . "-" . $fragments[1] . "-" . $fragments[0];
            return $formatted_date;
        }
    }
    
	/**
	 * Utils::DateToBr()
	 * Função para conversão da data que vem do banco Y-m-d, para novo formato 
     * 
	 * @param string $data Data no formato Y-m-d string
	 * @param string $format Formato desejado. Padrão: d/m/Y
	 * @return string Data formatada
	 */
	public static function DateToBr($data, $format = 'd/m/Y')
	{
	   if (!empty($data)) {
           $data = new DateTime($data);

           return $data->format($format);
       } else  {
            return "";
       } 
    }
    /*
        valorPorExtenso - ? :)
        Copyright (C) 2000 andre camargo
    
        This program is free software; you can redistribute it and/or modify
        it under the terms of the GNU General Public License as published by
        the Free Software Foundation; either version 2 of the License, or
        (at your option) any later version.
    
        This program is distributed in the hope that it will be useful,
        but WITHOUT ANY WARRANTY; without even the implied warranty of
        MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
        GNU General Public License for more details.
    
        You should have received a copy of the GNU General Public License
        along with this program; if not, write to the Free Software
        Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.
    
        Andr&eacute;) Ribeiro Camargo (acamargo@atlas.ucpel.tche.br)
        Rua Silveira Martins, 592/102
        Canguçu-RS-Brasil
        CEP 96.600-000
    */
    
    // funcao............: valorPorExtenso
    // ---------------------------------------------------------------------------
    // desenvolvido por..: andré camargo
    // versoes...........: 0.1 19:00 14/02/2000
    //                     1.0 12:06 16/02/2000
    // descricao.........: esta função recebe um valor numérico e retorna uma 
    //                     string contendo o valor de entrada por extenso
    // parametros entrada: $valor (formato que a função number_format entenda :)
    // parametros saída..: string com $valor por extenso
    public static function valorPorExtenso($valor=0) {
    	$rt ="";
    	
    	//$singular = array("centavo", "real", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
    	//$plural = array("centavos", "reais", "mil", "milhões", "bilhões", "trilhões", "quatrilhões");
    	
    	$singular = array(" ", " ", " ", " ", " ", " ", " ");
    	$plural = array(" ", " ", " ", " ", " ", " ", " ");
    
    	$c = array( "", "cem", "duzentos", "trezentos", "quatrocentos", "quinhentos", "seiscentos", 
                    "setecentos", "oitocentos", "novecentos");
    	$d = array( "", "dez", "vinte", "trinta", "quarenta", "cinquenta", "sessenta", "setenta", "oitenta", "noventa");
    	$d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze", "dezesseis", "dezesete", "dezoito", "dezenove");
    	$u = array("", "um", "dois", "três", "quatro", "cinco", "seis", "sete", "oito", "nove");
    
    	$z=0;
    
    	$valor = number_format($valor, 2, ".", ".");
    	$inteiro = explode(".", $valor);
    	for($i=0;$i<count($inteiro);$i++)
    		for($ii=strlen($inteiro[$i]);$ii<3;$ii++)
    			$inteiro[$i] = "0".$inteiro[$i];
    
    	// $fim identifica onde que deve se dar junção de centenas por "e" ou por "," ;)
    	$fim = count($inteiro) - ($inteiro[count($inteiro)-1] > 0 ? 1 : 2);
    	for ($i=0;$i<count($inteiro);$i++) {
    		$valor = $inteiro[$i];
    		$rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
    		$rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
    		$ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";
    	
    		$r = $rc.(($rc && ($rd || $ru)) ? " e " : "").$rd.(($rd && $ru) ? " e " : "").$ru;
    		$t = count($inteiro)-1-$i;
    		$r .= $r ? " ".($valor > 1 ? $plural[$t] : $singular[$t]) : "";
    		if ($valor == "000")$z++; elseif ($z > 0) $z--;
    		if (($t==1) && ($z>0) && ($inteiro[0] > 0)) $r .= (($z>1) ? " de " : "").$plural[$t]; 
    		if ($r) $rt = $rt . ((($i > 0) && ($i <= $fim) && ($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r;
    	}
    	
    	$rt = trim($rt, " ");
    
    	return($rt ? $rt : "zero");
    }
    
    
    
    public static function dataPorExtenso($data, $isSemana = false) {
    	// leitura das datas
    	$dia = date('d', $data);
    	$mes = date('m', $data);
    	$ano = date('Y', $data);
    	$semana = date('w', $data);
    	
    	
    	// configuração mes
    	switch ($mes){
    	
    		case 1: $mes = "JANEIRO"; break;
    		case 2: $mes = "FEVEREIRO"; break;
    		case 3: $mes = "MARÇO"; break;
    		case 4: $mes = "ABRIL"; break;
    		case 5: $mes = "MAIO"; break;
    		case 6: $mes = "JUNHO"; break;
    		case 7: $mes = "JULHO"; break;
    		case 8: $mes = "AGOSTO"; break;
    		case 9: $mes = "SETEMBRO"; break;
    		case 10: $mes = "OUTUBRO"; break;
    		case 11: $mes = "NOVEMBRO"; break;
    		case 12: $mes = "DEZEMBRO"; break;
    	
    	}
    	
    	
    	// configuração semana
    	$semana = Utils::diaSemanaPorExtenso($semana);
    
    	if($isSemana) {
    		return "$semana, $dia de ".ucwords(strtolower($mes))." de $ano";
    	} else {
    		return "$dia de ".ucwords(strtolower($mes))." de $ano";
    	}
    }
    
    public static function diaSemanaPorExtenso($intSemana)
    {
        $semana = "";
    	switch ($intSemana) {
    	
    		case 0: $semana = "DOMINGO"; break;
    		case 1: $semana = "SEGUNDA-FEIRA"; break;
    		case 2: $semana = "TERÇA-FEIRA"; break;
    		case 3: $semana = "QUARTA-FEIRA"; break;
    		case 4: $semana = "QUINTA-FEIRA"; break;
    		case 5: $semana = "SEXTA-FEIRA"; break;
    		case 6: $semana = "SÁBADO"; break;
    	
    	}
        
        return $semana;
    }

    /**
     * Função para converter um RowSet em valores válidos para as COMBOS criadas utilizando Zend Form.
     * @static
     * @param $rowset
     * @param $key_field
     * @param $label_field
     * @param null $firstElement
     * @param array $childFields Este campo recebe um array criado como o exemplo: array("form" => "nome do campo no form", "db-label" => "campo do banco que representará a label", "db-value" => "campo do banco que representará o value")
     * @return array
     * @throws Exception
     */
    public static function toComboValues($rowset, $key_field, $label_field, $firstElement = null, $childFields = array())
    {
        if(empty($label_field))
            throw new \Exception("Label não pode estar vazio ao converter para combo!");
        
        if(empty($rowset))
            throw new \Exception("Sem registros para converter para combo!");
            
        $result = array();
        
        if(!empty($firstElement))
            $result[""] = $firstElement; // vazio para travar no isValid do form

        $childValues = array();
        foreach($rowset as $row) {

            $label = "";
            if(is_array($label_field))
            {
                foreach($label_field as $key => $value)
                {                    
                    if(stripos($key, "separator") !== false)
                        $label .= $value;
                    else
                        $label .= $row->$value;
                }
            } 
            elseif(!empty($label_field) && (!empty($row->$label_field)))
                $label = $row->$label_field;

            if(!empty($childFields))
            {
                foreach($childFields as $childField)
                {
                    $formField = $childField["form"];
                    $dbLabelField = $childField["db-label"];
                    $dbKeyField = $childField["db-value"];

                    $childLabel = $row->$dbLabelField;
                    $childValue = $row->$dbKeyField;
                    if(!empty($childField["is_currency_value"]))
                        $childValue = number_format($childValue, 2, ",", "");

                    if(!empty($childField["is_currency_label"]))
                        $childLabel = number_format($childLabel, 2, ",", "");

                    if(!empty($childField["is_checkbox"]))
                    {
                        if(!empty($childLabel))
                            $childLabel = Application_Model_Sistema_Translate::getInstance()->_("SIM");
                        else
                            $childLabel = Application_Model_Sistema_Translate::getInstance()->_("NÃO");

                        if(!empty($childValue))
                            $childValue = Application_Model_Sistema_Translate::getInstance()->_("1");
                        else
                            $childValue = Application_Model_Sistema_Translate::getInstance()->_("0");
                    }

                    $childValues[$formField][][$childLabel] = $childValue;
                }
            }

            
            if(!empty($key_field))
                $result[$row->$key_field] = $label;
            else
                $result[] = $label;
        }

        if(!empty($childValues))
            return array_merge($result, $childValues);
        else
            return $result;
    }
}