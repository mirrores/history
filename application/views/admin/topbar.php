<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml"><HEAD><TITLE>myspace</TITLE>
        <META http-equiv=Content-Type content="text/html; charset=utf-8">
        <STYLE type="text/css">
            BODY{
                FONT-SIZE:12px;
                MARGIN:0px;
                padding:0
            }
            DIV{
                PADDING-RIGHT:0px;
                PADDING-LEFT:0px;
                PADDING-BOTTOM:0px;
                MARGIN:0px;
                PADDING-TOP:0px
            }
            .system_logo{
                FLOAT:left;
                MARGIN-LEFT:5px;
                WIDTH:160px;
                TEXT-ALIGN:left
            }
            #tabs{
                FLOAT:left;
                WIDTH:100%;
                LINE-HEIGHT:normal
            }
            #tabs UL{
                LIST-STYLE-TYPE:none
            }
            #tabs LI{
                PADDING-RIGHT:0px;
                DISPLAY:inline;
                PADDING-LEFT:0px;
                PADDING-BOTTOM:0px;
                MARGIN:0px;
                PADDING-TOP:0px
            }
            #tabs A{
                PADDING-RIGHT:0px;
                PADDING-LEFT:4px;
                BACKGROUND:url(/static/images/admin/tableft6.gif) no-repeat left top;
                FLOAT:left;
                PADDING-BOTTOM:0px;
                MARGIN:0px;
                PADDING-TOP:0px;
                TEXT-DECORATION:none;
                font-family:Verdana,Geneva,sans-serif
            }
            #tabs A SPAN{
                PADDING-RIGHT:8px;
                DISPLAY:block;
                PADDING-LEFT:6px;
                BACKGROUND:url(/static/images/admin/tabright6.gif) no-repeat right top;
                FLOAT:left;
                PADDING-BOTTOM:6px;
                COLOR:#e9f4ff;
                PADDING-TOP:8px
            }
            #tabs A SPAN{
                FLOAT:none
            }
            #tabs A:hover SPAN{
                COLOR:#fff
            }
            #tabs A:hover{
                BACKGROUND-POSITION:0% -42px
            }
            #tabs A:hover SPAN{
                BACKGROUND-POSITION:100% -42px;
                COLOR:#222
            }
            #tabs .ahover{
                PADDING-RIGHT:0px;
                PADDING-LEFT:4px;
                BACKGROUND:url(/static/images/admin/tableft6.gif) no-repeat 0% -42px;
                FLOAT:left;
                PADDING-BOTTOM:0px;
                MARGIN:0px;
                PADDING-TOP:0px;
                TEXT-DECORATION:none
            }
            #tabs .ahoverspan{
                BACKGROUND-POSITION:100% -42px;
                COLOR:#222
            }
        </STYLE>
        <script language="javascript" src="/static/js/jquery.js"></script>
        <script language="javascript">

            function switchSysBar() {
                if (1 == window.status) {
                    window.status = 0;
                    switchPoint.innerHTML = '<img src="images/left.gif">';
                    document.all("frmTitle").style.display = "none"
                }
                else {
                    window.status = 1;
                    switchPoint.innerHTML = '<img src="/static/images/admin/right.gif">';
                    document.all("frmTitle").style.display = ""
                }
            }
        </SCRIPT>
    </HEAD>
    <BODY>

        <table class="admin_table" border="0" style="BACKGROUND:url(/static/images/admin/top_bg.gif) repeat-x  ;width:100% ">
            <tbody>
                <tr>
                    <td style="width:100px"><a href="/" target="_blank" title="网站首页"><img src="/static/images/admin/admin_logo.gif" style="border:0;height:58px"></a></td>
                    <td style="height:58px"><DIV id="tabs" >
                            <UL id="topNav">
                                <?php
                                $admin_links = array(
                                    'admin_news' => '新闻中心',
                                    'admin_history' => '历史沿革'
                                );
                                ?>
                                <LI><a href="<?= URL::site('admin/count') ?>" target="frmright"  onFocus="this.blur();"  id="nav_home" class="ahover"><span class="ahoverspan">管理首页</span></a></LI>
                                <?php foreach ($admin_links as $link => $name): ?>
                                    <LI><a href="<?= URL::site($link) ?>" target="frmright"  onFocus="this.blur();"  id="nav_<?= $link ?>"><span><?= $name ?></span></a></LI>
                                            <?php endforeach; ?>

                            </UL>
                        </DIV></td>
                </tr>
            </tbody>
        </table>

        <script language="javascript">
            var $li = $("#topNav li");
            var $lia = $("#topNav a");
            var $lispan = $("#topNav span");

            $(document).ready(function() {
                $li.click(function() {
                    //去除高亮
                    $lia.removeClass('ahover');
                    $lispan.removeClass('ahoverspan');
                    //增加高亮
                    $(this).children("a").addClass('ahover');
                    $(this).children("a").children("span").addClass('ahoverspan');
                    parent.frmleft.disp($(this).children("a").attr("id"));
                });
            });

            function selectNav(obj) {

                $lia.removeClass('ahover');
                $lispan.removeClass('ahoverspan');

                var $navTab = $("#" + obj);
                $navTab.addClass('ahover');
                $navTab.children("span").addClass('ahoverspan');
            }
        </script>
    </BODY>
</HTML>
