<?php

class XmlUtil {

    private function __constract() {
        // Nothing to do
    }

    private function putHeader() {
        //header("Content-type: text/xml; charset=UTF-8");
    }

    public function getXML($data=null,$settingArray=null,$root='data') {

        // $data必须是数组
        if ($data == null || !is_array($data) || count($data) == 0) {
            return false;
        }


        // 生成DOM对象
        $dom = new DOMDocument('1.0', 'utf-8');

        // 创建DOM根元素
        $resultElement = $dom->createElement($root);

        // 循环组织DOM元素
        self::structDom($dom, $data, $resultElement,$settingArray);

        // 将创建完成的DOM元素加入DOM对象
        $dom->appendChild($resultElement);

        // 输出header
        self::putHeader();

        // 输出XML
        echo $dom->saveXML();
    }

    private function structDom($dom, $data, $result,$settingArray=null) {
        if (is_array($data)) {

            // 因为XML节点名不能为纯数字，所以这里需要进行一下判断
            foreach ($data as $key => $value) {
                if (is_numeric($key)) {
                    $tagName =isset($settingArray['itemName'])?$settingArray['itemName']: 'item';
                } else {
                    $tagName = $key;
                }

                // 递归转换为XML
                if (is_array($value)) {
                    $keyElement = $dom->createElement($tagName);
                    if (count($value) > 0) {
                        $result->appendChild($keyElement);
                        self::structDom($dom, $value, $keyElement);
                    } else {
                        $keyElement->appendChild($dom->createTextNode(''));
                        $result->appendChild($keyElement);
                    }
                } else {
                    $keyElement = $dom->createElement($tagName);
                    $keyElement->appendChild($dom->createTextNode($value));
                    $result->appendChild($keyElement);
                }
            }
            return $result;
        }
    }

}
