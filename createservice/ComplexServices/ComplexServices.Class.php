<?
use Bitrix\Highloadblock as HL;
use Bitrix\Main\Entity;

class ComplexServices{

    const  CATALOG_IB = 3;
    const  COMPLEX_IB = 26;
    const  STEPS_PIC_HB = 5;
    const  GENERATED_VALS_HB = 6;
    const  STEPS_HB = 4;
    const  NO_PRICE_PROP_ID = 25;
    const  NO_BASE_PROD_PROP_ID = 26;
    const  DEACTIVATED_PROD_PROP_ID = 27;
    public $errors;
    public $serviceErrors;
    public $complexService;
    public $complexServiceID;
    public $ID;
    public $picVals;
    public $steps;
    public $generated_vals;
    public $result;

    public function __construct( $serviceId = false ){
        if( $serviceId ){
            $this->ID = $serviceId;
        }
    }

    public function GetCS($id){
        if( $id > 0 )
        {
            $this->ID = $id;
            $result = $this->GetComplexService();
        }

        return $result;
    }

    public function GetComplexService(){
        if( $this->ID > 0 )
        {
            $result = array();
            $filter = array("IBLOCK_ID" => self::COMPLEX_IB,"ID" => $this->ID);
            $select = array("ID","IBLOCK_ID","NAME","PREVIEW_TEXT","ACTIVE","PREVIEW_PICTURE","DETAIL_PICTURE");
            $this->result = $result = self::GetCustomBxList(false,$filter,false,array(),$select);
            if(!$result)
            {
                return $this->errors[] = '“слуга не найдена';
            }else{
                $stepsID = $result["PROPS"]["STEPS"]["VALUE"];
                if( sizeof( $stepsID ) > 0)
                {
                    $this->result["STEPS"] = $this->GetStepsInfo( $stepsID );
                    if(!empty($this->result["STEPS"])){

                        foreach($this->result["STEPS"] as $stepID => $stepItem)
                        {
                            if(!empty($stepItem["UF_H4_PIC"]))
                            {
                                $this->result["PIC_VALS"][$stepID] = $this->GetPicVals( $stepItem["UF_H4_PIC"] );
                            }else{
                                $this->result["PIC_VALS"][$stepID] = array();
                            }
                        }
                    }
                }

                $genvalsID = $result["PROPS"]["GENERATED_VALUES"]["VALUE"];
                if( sizeof( $genvalsID ) > 0 )
                {
                    $this->result["GEN_VALS"] = $this->GetGenVals( $genvalsID );
                }

                return $this->result;
            }
        }else{
            return array();
        }

    }


    public function GetGenVals( $genValsID )
    {
        $genVals = array();
        if(!empty($genValsID))
        {
            $hbObj = $this->getHBClassObj(self::GENERATED_VALS_HB);
            $filter = array( "ID" => $genValsID );
            $select = array( "ID", "UF_H6_PICS","UF_H6_PROD","UF_NAME","UF_XML_ID" );
            $res = $hbObj::getList(array(
                'filter' => $filter,
                'select' => $select,
                'limit' => false,
                'order' => array('ID' => 'asc')
            ));
            while ($row = $res->fetch()) {
                $genVals[$row["ID"]] = $row;
            }
        }

        return $genVals;
    }

    public function GetPicVals( $picValIDs = array() )
    {
        $picVals = array();
        if(!empty($this->result["STEPS"]))
        {
            $picVals = array();
            $hbObj = $this->getHBClassObj(self::STEPS_PIC_HB);
			$filter = array();
			
            if($picValIDs)
                $filter = array( "ID" => $picValIDs );

            $select = array( "ID", "UF_CSPV_NAME","UF_CSPV_DESCR","UF_CSPV_PIC","UF_SORT" );
            $res = $hbObj::getList(array(
                'filter' => $filter,
                'select' => $select,
                'limit' => false,
                'order' => array('UF_SORT' => 'asc')
            ));
            while ($row = $res->fetch()) {
                $picVals[$row["UF_SORT"]] = $row;
            }

        }

        return $picVals;
    }

    public function GetStepsInfo( $stepsID )
    {
        $steps = array();
        $hbObj = $this->getHBClassObj(self::STEPS_HB);
        $filter = array('ID' => $stepsID);
        $select = array(
            'ID', 'UF_H4_NAME', 'UF_H4_PIC','UF_SORT'
        );
        $res = $hbObj::getList(
            array(
                'filter' => $filter,
                'select' => $select,
                'limit' => false,
                'order' => array('UF_SORT' => 'asc')
            )
        );
        while ($row = $res->fetch()) {
            $steps[$row["UF_SORT"]] = $row;
        }

        return $steps;

    }

    protected function generateCode($name)
    {
        $arr = array();
        $code = Cutil::translit($name, "ru");

        $arFilter = Array("IBLOCK_ID" => self::COMPLEX_IB, "CODE"=>"%".$code."%");
        $rsItems = CIBlockElement::GetList(Array(), $arFilter, false, false, Array("CODE"));
        if($rsItems->SelectedRowsCount() > 0) //проверка уникальности
        {
            while($arItem = $rsItems->Fetch())
            {
                if(preg_match('/^(.*)_(\d*)$/', $arItem["CODE"], $matches))
                {
                    if(!empty($matches[2])) $arr[] = $matches[2];
                }
            }

            $i = (!empty($arr)) ? (max($arr)) + 1 : 1;
            $code = $code.'_'.$i;
        }

        return $code;
    }

    public function CreateNewComplexService()
    {
        $iblock = new CIBlockElement;
        global $USER;
        $arFields = array(
            "MODIFIED_BY"    => $USER->GetID(), // элемент изменен текущим пользователем
            "IBLOCK_ID"      => self::COMPLEX_IB,
            "NAME"           => $_REQUEST["cs_name"],
            "CODE"          => $this->generateCode($_REQUEST["cs_name"]),
            "PREVIEW_TEXT"   => $_REQUEST["cs_description"],
            "PREVIEW_PICTURE" => CFile::MakeFileArray($_REQUEST["cs_pic_src"])
        );
        $arFields["ACTIVE"] = "N";
        if($_REQUEST["cs_activity"] == "Y")
        {
            foreach( $_REQUEST["GENERATE_VALS"] as $key => $val ){
                if($val["SERVICE"] < 1)
                {
                    if(!in_array(self::NO_BASE_PROD_PROP_ID,$this->serviceErrors))
                        $this->serviceErrors[] = self::NO_BASE_PROD_PROP_ID;
                }else{

                    $product_price = getProductPrice($val["SERVICE"],1);
                    if($product_price == "" && !in_array(self::NO_PRICE_PROP_ID,$this->serviceErrors))
                        $this->serviceErrors[] = self::NO_PRICE_PROP_ID;


                    if(!in_array(self::DEACTIVATED_PROD_PROP_ID,$this->serviceErrors))
                    {
                        $res = self::GetBxListObj(
                            array(),
                            array(
                                "IBLOCK_ID" => self::CATALOG_IB,
                                "=ID" => $val["SERVICE"],
                                "ACTIVE" => "N"
                            ),
                            false,
                            array(),
                            array("ID")
                        )->SelectedRowsCount();

                        if($res > 0){
                            $this->serviceErrors[] = self::DEACTIVATED_PROD_PROP_ID;
                        }
                    }
                }
            }

            if(empty($this->serviceErrors)){
                $arFields["ACTIVE"] = "Y";
            }
        }

        if($PRODUCT_ID = $iblock->Add($arFields)){
            $this->complexServiceID = $PRODUCT_ID;
        }else{
            $this->errors[] = $iblock->LAST_ERROR;
        }

        if(!empty($this->serviceErrors)){
            $serviceErrors = array("ERRORS" => $this->serviceErrors);
            $this->SetProp($this->complexServiceID,$serviceErrors);
        }

        if(is_array($_REQUEST["cs_category"]) && !empty($_REQUEST["cs_category"])) {
            $catAddArr = array("SECTION" => array_diff($_REQUEST["cs_category"], array('')));
            $this->SetProp($this->complexServiceID,$catAddArr);
        } elseif((int)$_REQUEST["cs_category"] > 0 ) {
            $catAddArr = array("SECTION" => (int)$_REQUEST["cs_category"]);
            $this->SetProp($this->complexServiceID,$catAddArr);
        }

        //‘оздадим ?аги
        $steps = $this->createSteps($_REQUEST["step"]);

        //‘оздадим сгенерированные значениЯ
        if( sizeof($_REQUEST["GENERATE_VALS"]) > 0 )
        {
            $genVals = $this->AddGenerateValsToHb($_REQUEST["GENERATE_VALS"]);
        }

        $stepsIDS = array_keys($steps);
        $getValsIDS = array_keys($genVals);

        $this->SetProp($this->complexServiceID,array("STEPS" => $stepsIDS));
        $this->SetProp($this->complexServiceID,array("GENERATED_VALUES" => $getValsIDS));

        //$this->CheckErrors();

        return $PRODUCT_ID;

    }


    public function CheckErrors(){
    }

    public function CopyService($ID = false){
        $result= array();
        if($ID > 0)
            $this->ID = $ID;

        if($this->ID > 0){
            $result = $this->GetComplexService();

            $iblock = new CIBlockElement;
            global $USER;
            $arFields = array(
                "MODIFIED_BY"    => $USER->GetID(), // элемент изменен текущим пользователем
                "IBLOCK_ID"      => self::COMPLEX_IB,
                "NAME"           => $result["NAME"],
                "CODE"          => $this->generateCode($result["NAME"]),
                "ACTIVE"         => "N",
                "PREVIEW_TEXT"   => "",
                "PREVIEW_PICTURE" => CFile::MakeFileArray($result["PREVIEW_PICTURE"])
            );

            if($PRODUCT_ID = $iblock->Add($arFields)){
                $this->complexServiceID = $PRODUCT_ID;
            }else{
                $this->errors[] = $iblock->LAST_ERROR;
            }

            if(empty($this->errors))
            {
                if(is_array($result["PROPS"]["SECTION"]["VALUE"]) && !empty($result["PROPS"]["SECTION"]["VALUE"])) {
                    $catAddArr = array("SECTION" => $result["PROPS"]["SECTION"]["VALUE"]);
                    $this->SetProp($this->complexServiceID,$catAddArr);
                } elseif( $result["PROPS"]["SECTION"]["VALUE"] > 0){
                    $catAddArr = array("SECTION" => (int)$result["PROPS"]["SECTION"]["VALUE"]);
                    $this->SetProp($this->complexServiceID,$catAddArr);
                }

                $pics = $this->CopyPicVals($result["PIC_VALS"]);
                if( sizeof($pics) > 0 )
                {
                    $genVals = $this->CopyGenVals($result["GEN_VALS"],$pics);
                    $this->SetProp($this->complexServiceID,array("GENERATED_VALUES" => $genVals));
                }


                if( sizeof($result["STEPS"]) > 0 )
                {
                    $steps = $this->CopyStepsVals($result["STEPS"],$pics);
                    $this->SetProp($this->complexServiceID,array("STEPS" => $steps));
                }

                return $PRODUCT_ID;

            }else{
                return false;
            }

        }

        return $result;
    }

    public function CopyGenVals($arGenVals,$pics)
    {
        $result = array();
        if(sizeof($pics) > 0 && sizeof($arGenVals) > 0)
        {
            foreach($arGenVals as $key => $value)
            {
                $fields = $value;
                unset($fields["ID"]);
                unset($fields["XML_ID"]);
                $fields["SERVICE"] = $fields["UF_H6_PROD"];
                $fields["NAME"] = $fields["UF_NAME"];
                $result[] = $this->AddGenerateValsSimple($pics,$fields);
            }
        }
        return $result;
    }


    public function CopyStepsVals($steps,$pic = false)
    {
        $result = array();
        if(!empty($steps))
        {

            foreach($steps as $stKey => $stVal)
            {
                if( sizeof($stVal["UF_H4_PIC"]) > 0 )
                {
                    foreach($stVal["UF_H4_PIC"] as $key => $val)
                    {
                        $stVal["UF_H4_PIC"][$key] = $pic[$val];
                    }
                }else{
                    $stVal["UF_H4_PIC"] = array();
                }
                $fields = $stVal;
                unset($fields["ID"]);
                $result[] = $this->AddStepsToHb($fields["UF_H4_NAME"],$fields["UF_H4_PIC"],$fields["UF_SORT"],"ID");
            }
        }
        return $result;
    }


    public function CopyPicVals($arPics)
    {
        if( sizeof($arPics) >0 )
        {
            foreach ($arPics as $step => $arPicsVals) {
                foreach($arPicsVals as $picKey => $picVal){
                    $hbObj = $this->getHBClassObj(self::STEPS_PIC_HB);
                    $fields = $picVal;
                   /* if($fields["UF_CSPV_PIC"] > 0){
                        $fields["UF_CSPV_PIC"] = CFile::MakeFileArray($fields["UF_CSPV_PIC"]);
                    }*/
                    $fields["UF_CSPV_PIC"] = "";
                    unset($fields["ID"]);
                    $result = $hbObj::add($fields);
                    $ID =  $result->getId();
                    $pics[$picVal["ID"]] = $ID;
                }
            }
            return $pics;
        }
    }


    public function PrepareRequestForComplexService($request)
    {
        $arResult = array();
        if(sizeof($request) > 0)
        {
            foreach($request["step"] as $key => $value)
            {
                $arResult["STEPS"][] = $value["ID"];
            }
        }

        $arResult["NAME"] = $request["cs_name"];
        $arResult["PREVIEW_TEXT"] = $request["cs_description"];
        $arResult["SECTION"] = $request["cs_category"];
        $arResult["ACTIVE"] = "Y";

        return $arResult;
    }


    public function UpdateComplexService($request,$genVals)
    {
        if($this->ID > 0 && sizeof($request) > 0)
        {
            $fields = $this->PrepareRequestForComplexService($request);
            $el = new CIBlockElement;
            $PROP = array();
            $PROP[109] = $genVals;
            $PROP[108] = $fields["STEPS"];
            $PROP[107] = $fields["SECTION"];
            $arLoadProductArray = Array(
                "PROPERTY_VALUES" => $PROP,
                "NAME"            => $fields["NAME"],
                "CODE"          => $this->generateCode($fields["NAME"]),
                "PREVIEW_TEXT"    => $fields["PREVIEW_TEXT"],
            );

            if($request["cs_activity"] == 'Y')
            {
                foreach( $request["GENERATE_VALS"] as $key => $val ){
                    if($val["SERVICE"] < 1)
                    {
                        if(!in_array(self::NO_BASE_PROD_PROP_ID,$this->serviceErrors))
                            $this->serviceErrors[] = self::NO_BASE_PROD_PROP_ID;
                    }else{

                        $product_price = getProductPrice($val["SERVICE"],1);
                        if($product_price == "" && !in_array(self::NO_PRICE_PROP_ID,$this->serviceErrors))
                            $this->serviceErrors[] = self::NO_PRICE_PROP_ID;


                        if(!in_array(self::DEACTIVATED_PROD_PROP_ID,$this->serviceErrors))
                        {
                            $res = self::GetBxListObj(
                                array(),
                                array(
                                    "IBLOCK_ID" => self::CATALOG_IB,
                                    "=ID" => $val["SERVICE"],
                                    "ACTIVE" => "N"
                                ),
                                false,
                                array(),
                                array("ID")
                            )->SelectedRowsCount();

                            if($res > 0){
                                $this->serviceErrors[] = self::DEACTIVATED_PROD_PROP_ID;
                            }
                        }
                    }
                }

                if(empty($this->serviceErrors))
                    $arLoadProductArray["ACTIVE"] = "Y";
                else
                    $arLoadProductArray["ACTIVE"] = "N";
            }else{
                $arLoadProductArray["ACTIVE"] = "N";
            }

            if($request["cs_pic_src"] == "" && $request["cs_pic_id"] == "")
                $arLoadProductArray["PREVIEW_PICTURE"] =  array('del' => 'Y');
            else if($request["cs_pic_src"] != "")
                $arLoadProductArray["PREVIEW_PICTURE"] = CFile::MakeFileArray($request["cs_pic_src"]);
            $res = $el->Update($this->ID, $arLoadProductArray);

            if(!empty($this->serviceErrors)){
                $serviceErrors = array("ERRORS" => $this->serviceErrors);
                $this->SetProp($this->ID,$serviceErrors);
            }
        }
    }

    public function ShowErrors()
    {
        $str = '<div class="alert alert-danger">';
        foreach($this->errors as $key => $value)
        {

            $str.= '<b>'.$value.'</b>';
        }
        $str.="</div>";
        echo $str;
    }

    public function getPicIDsByExpKey($key)
    {
        $res = array();
        if($key != ""){
            $keyArr = explode("_",$key);
            foreach($keyArr as $k_keyarr => $k_keyarr_val)
            {
                $res[] = $this->picVals[$k_keyarr_val]["ID"];
            }
        }

        return $res;
    }

    public function UpdateGenVal($ID,$arr,$fields){
        if($ID > 0 && sizeof($arr) > 0 && sizeof($fields) > 0)
        {
            $hbObj = $this->getHBClassObj(self::GENERATED_VALS_HB);
            $addFields["UF_NAME"] = $fields["NAME"];
            $addFields["UF_H6_PROD"] = $fields["SERVICE"];
            $addFields["UF_H6_PICS"] = $arr;
            $hbObj::Update($ID,$addFields);
        }
    }

    public function AddGenerateValsSimple($arr,$fields){
        if(sizeof($arr) > 0 && sizeof($fields) > 0)
        {
            $hbObj = $this->getHBClassObj(self::GENERATED_VALS_HB);
            $addFields["UF_NAME"] = $fields["NAME"];
            $addFields["UF_H6_PROD"] = $fields["SERVICE"];

            $oldPics = $fields["UF_H6_PICS"];
            if(sizeof($oldPics) > 0)
            {
                $fields["UF_H6_PICS"] = array();
                foreach($oldPics as $k => $v)
                {
                    $fields["UF_H6_PICS"][] = $arr[$v];
                }
            }else{
                $fields["UF_H6_PICS"] = $arr;
            }

            $addFields["UF_H6_PICS"] = $fields["UF_H6_PICS"];
            $result = $hbObj::add($addFields);
            $ID = $result->getId();
            $hbObj::update($ID, array("UF_XML_ID" => $ID));

            return $ID;
        }
    }

    public function AddGenerateValsToHb($arr){
        $hbObj = $this->getHBClassObj(self::GENERATED_VALS_HB);
        $res = array();
        if(!empty($arr)){
            foreach($arr as $key => $item){
                $addFields["UF_NAME"] = $item["NAME"];
                $addFields["UF_H6_PROD"] = $item["SERVICE"];
                $addFields["UF_H6_PICS"] = $this->getPicIDsByExpKey($key);

                $result = $hbObj::add($addFields);
                $ID =  $result->getId();
                //установим XML, bitrix(((
                $hbObj::update($ID, array("UF_XML_ID" => $ID));
                $genValsRows = $hbObj::getById($ID)->fetch();
                $this->generated_vals[$ID] = $genValsRows;
            }
        }
        return $this->generated_vals;
    }


    public function getHBClassObj($HB_ID)
    {
        if($HB_ID > 0)
        {
            $hlblock_requests = HL\HighloadBlockTable::getById($HB_ID)->fetch();//requests
            $entity_requests = HL\HighloadBlockTable::compileEntity($hlblock_requests);
            $entity_requests_data_class = $entity_requests->getDataClass();
        }

        return $entity_requests_data_class;
    }

    public function AddPicValsToHb($arr,$step){
        $hbObj = $this->getHBClassObj(self::STEPS_PIC_HB);
        if( sizeof($arr) > 0 )
        {
            foreach( $arr["PICVAL"]  as $picID => $picItem )
            {
                if(trim($picItem["DESCR"]) != "" )
                {
                    $addFields = $this->PreparePicValsInfo($picItem);
                    if(!empty($addFields))
                    {
                        $result = $hbObj::add($addFields);
                        $ID =  $result->getId();
                        $resIDS[] = $ID;
                        $picValRows = $hbObj::getById($ID)->fetch();
                        $this->picVals[$step.$picID] = $picValRows;
                    }
                }
            }
        }
        return $resIDS;
    }

    public function UpdateSteps($ID,$arr){
        if(sizeof($arr) > 0 && $ID > 0)
        {
            $hbObj = $this->getHBClassObj(self::STEPS_HB);
            $result = $hbObj::Update($ID,$arr);
        }
    }
    public function PreparePicValsInfo($arr){
        $res = array();
        if( sizeof($arr) > 0 )
        {
            $res["UF_CSPV_NAME"] = $arr["DESCR"];
            $res["UF_CSPV_DESCR"] = $arr["HINT"];
            $res["UF_SORT"] = $arr["sort"];

            if($arr["THMB"]["pic_id"] == "" && $arr["THMB"]["src"] == "")
            {
                $res["UF_CSPV_PIC"] = "";
            }

            if($arr["THMB"]["src"] != "")
            {
                $src = str_replace("/createservice//","/createservice/",$arr["THMB"]["src"]);
                $file = CFile::MakeFileArray($src);
                $res["UF_CSPV_PIC"] = $file;
            }
        }
        return $res;
    }

    public function PrepareStepsFromRequest($arr){
        if(sizeof($arr) > 0){
            //получим все айдишники картинок
            foreach($arr["PICVAL"] as $pic_key => $pic_val)
            {
                if($pic_val["ID"] != "")
                    $picIDS[] = $pic_val["ID"];
            }

            $res["UF_H4_NAME"] = $arr["DESCRIPTION"];
            $res["UF_H4_PIC"] = $picIDS;
            $res["UF_SORT"] = $arr["SORT"];

            return $res;
        }
    }

    public function UpdatePicVal($ID,$fields)
    {
        if(!empty($fields) && $ID > 0)
        {

            $hbObj = $this->getHBClassObj(self::STEPS_PIC_HB);
            $hbObj::update($ID, $fields);
        }
    }

    public function AddNewPicVal($arr){
        if(sizeof($arr) > 0)
        {
            $fields = $this->PreparePicValsInfo($arr);
            if($fields["UF_CSPV_NAME"] != "" || $fields["UF_CSPV_PIC"] != "")
            {
                $hbObj = $this->getHBClassObj(self::STEPS_PIC_HB);
                $result = $hbObj::add($fields);
                $ID =  $result->getId();
                $fields["ID"] = $ID;
                return $fields;
            }
        }
    }

    public function AddStepsToHb($name,$picVals,$sort,$returnType=false){
        $hbObj = $this->getHBClassObj(self::STEPS_HB);
        $res["UF_H4_NAME"] = $name;
        $res["UF_H4_PIC"] = $picVals;
        $res["UF_SORT"] = $sort;

        $result = $hbObj::add($res);
        $ID =  $result->getId();
        $steps = $hbObj::getById($ID)->fetch();
        $hbObj::update($ID, array("UF_XML_ID" => $ID));
        $steps["PICS_ID"] = $picVals;

        if($returnType == "ID")
        {
            return $ID;
        }else{
            $this->steps[$ID] = $steps;
            return $this->steps;
        }
    }

    public function createSteps($step = array()){
        $arResult = array();
        if( sizeof($step) > 0 )
        {
            CModule::IncludeModule("highloadblock");
            $picVals = array();//id значений - картинок

            foreach( $step as $key => $stepInfoArr )
            {
                $picVals = $this->AddPicValsToHb($stepInfoArr,$key);
                if(!empty($picVals) || trim($stepInfoArr["DESCRIPTION"]) != ""  )
                {
                   $arResult =  $this->AddStepsToHb($stepInfoArr["DESCRIPTION"],$picVals,$key);
                }
            }
        }
        return $arResult;
    }

    public function SetProp($ID,$PROP_ARR){
        if($ID > 0 && sizeof($PROP_ARR) > 0)
        {
            CIBlockElement::SetPropertyValuesEx($ID, false, $PROP_ARR);
        }
    }


    public function RemovePicVal( $ID )
    {
        if($ID > 0) {

            /*$hbObj = $this->getHBClassObj(self::STEPS_PIC_HB);
            $hbObj::Delete($ID);*/

            //получим все сгенерированные значениЯ которые нужно удалить
            $hbGenObj = $this->getHBClassObj(self::GENERATED_VALS_HB);
            $filter = array( "UF_H6_PICS" => $ID );
            $select = array( "ID");
            $res = $hbGenObj::getList(array(
                'filter' => $filter,
                'select' => $select,
                'limit' => false,
                'order' => array('ID' => 'asc')
            ));

            while ($row = $res->fetch()) {
                $hbGenObj::Delete($row["ID"]);
            }

            //удалЯем картинки значениЯ
            $hbObj = $this->getHBClassObj(self::STEPS_PIC_HB);
            $hbObj::Delete($ID);
        }
    }

    public function RemoveStepEasy( $stepID ){
        if($stepID > 0)
        {
            $hbObj = $this->getHBClassObj(self::STEPS_HB);
            $hbObj::Delete( $stepID );
        }
    }


    public function RemoveComplexService($serviceID = false){
        if($serviceID > 0){
            $this->ID = $serviceID;
        }
        if($this->ID > 0){
            $result = $this->GetComplexService();
            if(sizeof($this->errors) < 1)
            {
                $arSteps = $result["STEPS"];
                foreach($arSteps as $key => $value)
                {
                    $this->RemoveStepEasy($value["ID"]);
                    if(sizeof($value["UF_H4_PIC"]) > 0){
                        foreach($value["UF_H4_PIC"] as $pic_key => $pic_val){
                            $this->RemovePicVal($pic_val);
                        }
                    }
                }

                $delResult = CIBlockElement::Delete($this->ID);
                if(!$delResult)
                {
                    $this->errors[] = 'Џроизошла ошибка, повторите попытку позже';
                    return false;
                }else{
                    return true;
                }
            }else{
                return false;
            }
        }else{
            $this->errors[] = 'ќлемент не найден!';
            return false;
        }
    }

    public static function GetCategoris( $IBLOCK_ID = false ){
        if( !$IBLOCK_ID )
            $IBLOCK_ID = self::CATALOG_IB;

            $arFilter = array("IBLOCK_ID" => $IBLOCK_ID);
            $db_list = CIBlockSection::GetList(array(), $arFilter, true);
            while($ar_result = $db_list->GetNext())
            {
                $intCount = CIBlockSection::GetCount(array('IBLOCK_ID' => $IBLOCK_ID,'SECTION_ID' => $ar_result["ID"]));
                //if($intCount == 0)
                //{
                    $path = '';
                    $nav = CIBlockSection::GetNavChain(false, $ar_result["ID"]);
                    while($arSectionPath = $nav->GetNext()){
                        if($path == '')
                            $path .= $arSectionPath["NAME"];
                        else
                            $path .= ' / '.$arSectionPath["NAME"];
                    }

                    $arResult[$ar_result["ID"]] = $ar_result;
                    $arResult[$ar_result["ID"]]["PATH_NAME"] = $path;
                //}
            }

        return $arResult;
    }

    public static function GetSimpleServices(){
        $filter = array("IBLOCK_ID" => self::CATALOG_IB);
        $select = array("IBLOCK_ID","ID","NAME","XML_ID","ACTIVE");
        $simpleServices = self::GetCustomBxList(array("XML_ID" => "ASC"),$filter,false,false,$select);
        foreach($simpleServices as $k => $v)
        {

            $price = getProductPrice($k,1);
            if($v["ACTIVE"] == "N")
                $simpleServices[$k]["ERRORS"][] = "деактивирована";
            if($price == "")
                $simpleServices[$k]["ERRORS"][] = "нет цены";
        }

        return $simpleServices;
    }

    public static function GetCustomBxList($arSort,$arFilter,$groupParams,$arPageParams,$arSelect){
        $obj = self::GetBxListObj($arSort,$arFilter,$groupParams,$arPageParams,$arSelect);
        $result = self::PrepareBxObj($obj);
        return $result;
    }

    public static function GetBxListObj($arSort,$arFilter,$groupParams = false,$arPageParams,$arSelect){
        $res = CIBlockElement::GetList($arSort, $arFilter, false,$arPageParams, $arSelect);
        return $res;
    }

    public static function PrepareBxObj($obj)
    {
        if($obj)
        {
            while($ob = $obj->GetNextElement())
            {
                $arFields = $ob->GetFields();
                $arResult[$arFields["ID"]] = $arFields;
                $arResult[$arFields["ID"]]["PROPS"] = $ob->GetProperties();
            }

            if(sizeof($arResult) == 1) {
                $keys = array_keys($arResult);
                $arResult = $arResult[$keys[0]];
            }
        }
        return $arResult;
    }

    public static function DeepConv( $from, $to, $sbj )
    {
        if (is_array($sbj) || is_object($sbj)){
            foreach ($sbj as &$val){
                $val= self::DeepConv($from, $to, $val);
            }
            return $sbj;
        }else{
            return iconv($from, $to, $sbj);
        }
    }

    public static function UpdateAllGenVals(){
        $cx = new ComplexServices();

            $hbObj = $cx->getHBClassObj(self::GENERATED_VALS_HB);
            $filter = array( "UF_XML_ID" => "" );
            $select = array( "ID", "UF_H6_PICS","UF_H6_PROD","UF_NAME","UF_XML_ID" );
            $res = $hbObj::getList(array(
                'filter' => $filter,
                'select' => $select,
                'limit' => false,
                'order' => array('ID' => 'asc')
            ));
            while ($row = $res->fetch()) {
                $hbObj::Update($row["ID"],array("UF_XML_ID" => $row["ID"]));
            }
    }
}


?>