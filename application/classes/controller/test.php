<?php

class Controller_Test extends Layout_Main {
    
    public function before() {
        parent::before();
    }

    function action_index() {
        $content= '<p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1466.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1467.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1470.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1472.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1474.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1475.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1476.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1478.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1479.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1480.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1482.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1483.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1484.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1485.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1486.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1487.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1488.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1490.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1492.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1493.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1494.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1495.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1496.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1497.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1500.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1501.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1502.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1504.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1505.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1506.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1508.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1509.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1510.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1511.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1512.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1513.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1514.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1515.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1516.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1518.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1519.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1521.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1522.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1523.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1524.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1525.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1526.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1527.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1528.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1529.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1530.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1531.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1532.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1533.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1534.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1535.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1536.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1537.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1538.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1539.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1540.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1541.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1542.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1543.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1544.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1546.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1547.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1549.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1550.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1551.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1552.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1553.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1554.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1555.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1556.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1557.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1558.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1559.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1561.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1562.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1565.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1567.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1569.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1570.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1572.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1574.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1575.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1576.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1578.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1579.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1580.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1581.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1583.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1585.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1587.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1588.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1590.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1591.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1592.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1594.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1595.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1596.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1597.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1598.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1599.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1601.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1602.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1603.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1604.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1605.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1606.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1607.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1608.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1609.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1610.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1612.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1613.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1614.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1615.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1616.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1617.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1618.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1619.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1621.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1622.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1623.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1626.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1629.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1630.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1631.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1632.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1634.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1635.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1636.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1637.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1639.JPG</p><p>http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/end/TXD_1640.JPG</p>';
        $pattern = "/<p>(.*)<\/p>/U";
        preg_match_all($pattern, $content, $array);
        
        echo '<textarea style="width:100%;height:500px">';
        if(isset($array[1]) AND count($array[1])){
            foreach($array[1] AS $p){
                $sp=  str_replace('http://zuaa.zju.edu.cn','',$p);
                $sp=  str_replace('2013fall/end/','2013fall/mini/',$sp);
                $sp=  str_replace('.JPG','.jpg',$sp);
                echo '<p><img src="'.$sp.'"/><br>原图：<a href="'.$p.'" target="_blank">'.$p.'</a><br></p>';
            }
        }
        echo '</textarea>';
    }
    
    function action_qidian() {
        $content='<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2409.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2411.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2417.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2420.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2422.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2425.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2427.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2430.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2433.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2435.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2441.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2442.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2445.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2448.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2451.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2452.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2455.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2459.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2460.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2464.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2465.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2467.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2470.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2472.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2474.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2476.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2479.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2481.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2483.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2485.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2488.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2491.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2492.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2494.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2497.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2498.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2500.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2504.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2506.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2509.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2512.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2514.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2517.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2519.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2522.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2524.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2527.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2528.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2531.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2533.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2536.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2538.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2541.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2543.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2544.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2548.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2549.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2552.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2553.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2555.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2558.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2559.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2561.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2571.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2573.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2577.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2581.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2583.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2585.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2586.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2589.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2591.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2593.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2595.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2598.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2599.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2601.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2603.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2605.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2608.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2611.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2613.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2615.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2617.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2620.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2621.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2623.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2625.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2627.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2630.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2631.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2633.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2635.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2638.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2641.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2645.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2647.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2650.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2651.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2653.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2656.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2657.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2661.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2664.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2668.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2669.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2671.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2673.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2676.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2678.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2682.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2683.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2685.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2691.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2695.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC2700.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC6503.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC6505.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC6507.jpg</span>
</p>

<p>
    <span style="FONT-FAMILY: Calibri">http://zuaa.zju.edu.cn/static/upload/attached/trailwalk/2013fall/start/ZDSC6509.jpg</span>
</p>

<p></p>';
        $pattern = "/http:\/\/(.*)\.jpg/U";
        preg_match_all($pattern, $content, $array);
        
        echo '<textarea style="width:100%;height:500px">';
        if(isset($array[0]) AND count($array[0])){
            foreach($array[0] AS $p){
                $sp=  str_replace('http://zuaa.zju.edu.cn','',$p);
                $sp=  str_replace('2013fall/start/','2013fall/mini0/',$sp);
                $sp=  str_replace('.JPG','.jpg',$sp);
                echo '<p><img src="'.$sp.'"/><br>原图：<a href="'.$p.'" target="_blank">'.$p.'</a><br></p>';
            }
        }
        echo '</textarea>';
    }



}