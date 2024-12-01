<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

if (!CModule::IncludeModule("iblock")) {
    ShowError("ошибка");
    return;
}

$arResult = [];

$res = CIBlockElement::GetList(
    ["SORT" => "ASC"],
    ["IBLOCK_ID" => $arParams["IBLOCK_ID"], "ACTIVE" => "Y"],
    false,
    false,
    ["ID", "NAME", "PREVIEW_TEXT", "DETAIL_TEXT", "PROPERTY_*"]
);

while ($element = $res->Fetch()) {
    $arResult[] = $element;
}

$this->IncludeComponentTemplate();
?>
