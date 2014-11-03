<!-- event/view:_body -->
<?php $etype = Kohana::config('icon.etype'); ?>
<?php $icon = $event_data['event']['type'] ? $etype['icons'][$event_data['event']['type']] : 'undefined.png'; ?>
<script language="javascript" type="text/javascript" src="/static/My97DatePicker/WdatePicker.js"></script>
<p><a href="<?= URL::site('event') ?>" title="回活动首页"><img src="/static/images/event_title.gif" ></a></p>
<?php if ($event_data['event']['is_closed']): ?>
    <div style="color:#f60; background: #FAFAD6; border: 1px solid #F0EAAA; padding:20px; margin-bottom:15px">很抱歉，该活动已经关闭:)</div>
<?php else: ?>
    <div class="view_name">
        <img src="<?= $etype['url'] . $icon ?>" align="absmiddle"  style="margin-right: 10px"  />
        <?= Text::limit_chars($event_data['event']['title'], 40, '...') ?><?php if ($event_data['event']['is_suspend']): ?>(活动暂停)<?php endif; ?><?php if ($event_data['event']['is_vcert']): ?><span style="vertical-align: middle">&nbsp;&nbsp;<img src="/static/images/ico_vcert.png" id="ico_vcert" title="校友会认证活动" ></span><?php endif; ?>
        <div class="join">
                <?php if (time() >= strtotime($event_data['event']['start']) AND time() <= strtotime($event_data['event']['finish'])): ?>
                    <input type="button"  value="活动进行中"  class="button_disabled"  disabled="disabled" id="event_finish" style="color:#007C00"/>
                <?php elseif (time() >= strtotime($event_data['event']['finish'])): ?>
                    <input type="button"  value="活动已结束"  class="button_disabled"  disabled="disabled" id="event_finish"/>
                <?php elseif ($event_data['event']['is_suspend']): ?>
                    <input type="button"  value="活动暂停"  class="button_disabled"  disabled="disabled" id="event_finish"/>
                <?php elseif ($_UID && $event_data['user_sign_status']['is_signed']): ?>
                    <input type="button" onclick="editSign(<?= $event_data['event']['id'] ?>)" value="修改/取消报名"  class="button_gray" id="sign_button"/>
                <?php elseif ($event_data['event']['is_stop_sign']): ?>
                    <input type="button"  value="暂停报名"  class="button_disabled"  disabled="disabled" id="event_finish"/>
                <?php elseif ($event_data['event']['sign_limit'] > 0 AND $event_data['total_sign'] >= $event_data['event']['sign_limit']): ?>
                    <input type="button"  value="名额已满"  class="button_disabled"  disabled="disabled" id="event_finish"/>
                <?php elseif ($_UID): ?>
                    <input type="button" onclick="signForm(<?= $event_data['event']['id'] ?>)" value=""   id="sign_button" class="signeventbutton"/>
                <?php else: ?>
                    <div style="color:#999;font-size:12px; font-weight: normal">您还没有登录，请<a href="javascript:;" onclick="loginForm('<?= isset($redirect) ? $redirect : $_URL; ?>')" id="flogin_btn" >登录</a>后报名！</div>
                <?php endif; ?>
        </div>
    </div>

    <div class="view_title"><span class="middle"><img src="/static/images/ico_page.gif"></span>基本信息</div>
    <div class="view_box" >
        <b>发起：</b> <a href="<?= URL::site('user_home?id=' . $event_data['event']['user_id']) ?>"><?= $event_data['organiger']['realname'] ?></a><br>
        <b>时间：</b><?php if (date('Y-m-d', strtotime($event_data['event']['start'])) == date('Y-m-d', strtotime($event_data['event']['finish']))): ?><?= date('Y年m月d日', strtotime($event_data['event']['start'])) ?>&nbsp;<?= date('H:i', strtotime($event_data['event']['start'])) ?>~<?= date('H:i', strtotime($event_data['event']['finish'])) ?><?php else: ?><?= date('Y年m月d日 H:i', strtotime($event_data['event']['start'])) ?> ~ <?= date('m月d日 H:i', strtotime($event_data['event']['finish'])) ?><?php endif; ?><br>
        <b>所属：</b><?php if ($event_data['event']['aa_id'] == '-1'): ?><a href="<?= URL::site('aa') ?>"><?= $_CONFIG->base['orgname'] ?></a><?php else: ?><a href="<?= URL::site('aa_home?id=' . $event_data['event']['aa_id']) ?>" title="进入校友会主页"><?= $event_data['aa']['name'] ?></a><?php endif; ?>
        <?php if ($event_data['event']['club_id']): ?>
            &raquo; <a href="<?= URL::site('club_home/?id=' . $event_data['event']['club_id']) ?>"><?= $event_data['club']['name'] ?></a>
        <?php endif; ?><br>
        <b>地址：</b><?= $event_data['event']['address'] ?><br>
        <b>人数：</b><?= $event_data['event']['sign_limit'] ? $event_data['event']['sign_limit'] . '人' : '不限'; ?>  <?= $event_data['total_sign'] ? '已有' . $event_data['total_sign'] . '人报名' : ''; ?><br>
        <?php if (!empty($tags)): ?><b>标签：</b>
            <?php foreach ($tags as $name): ?>
                <a href="<?= URL::site('event?tag=' . urlencode($name)) ?>"><?= $name ?></a>&nbsp;&nbsp;
            <?php endforeach; ?><br>
        <?php endif; ?>
        <b>状态：</b><? // Model_Event::signStatus($event_data['event'])                ?><?= Model_Event::status($event_data['event']) ?><br>
        <?php if ($event_data['event']['votes'] > 0): ?><b>体验：</b><?php for ($i = 1; $i <= $event_data['event']['score']; $i++): ?><img src="/static/images/knewstuff.png" style="margin-right:2px;vertical-align: middle"><?php endfor; ?><?php for ($i = 1; $i <= 5 - $event_data['event']['score']; $i++): ?><img src="/static/images/knewstuff2.png" style="margin-right:2px;vertical-align: middle"><?php endfor; ?>&nbsp;&nbsp;<span style="color:#999"><?= $event_data['event']['votes'] ?>人评分</span><br><?php endif; ?>
        <?php if ($event_data['permission']['is_edit_permission']): ?>
            <div style="text-align:right">
                <a href="javascript:;" onclick="quick_edit(<?= $event_data['event']['id'] ?>)" class="ico_edit">快速编辑</a>&nbsp;
                 <?php if($event_data['event']['category_label']):?><a href="<?= URL::site('event/signCategorys?event_id=' . $event_data['event']['id']) ?>" class="ico_group">分组管理</a>&nbsp;<?php endif; ?>
                <a href="<?= URL::site('event/form?id=' . $event_data['event']['id']) ?>" class="ico_edit">编辑</a>&nbsp;
                <a href="javascript:del(<?= $event_data['event']['id'] ?>)" class="ico_del" title="删除该话题">删除</a>
            </div>
        <?php endif; ?>

    </div>

    <div class="view_title"><span class="middle"><img src="/static/images/ico_morepage.gif"></span>活动介绍</div>
    <div class="view_box event_content">
        <?= Emotion::autoToUrl($event_data['event']['content']); ?>
    </div>
    <div id="interested_box" style="margin:10px 15px"><?= View::factory('event/interested', array('event_id' => $event_data['event']['id'], 'interested_num' => $event_data['event']['interested_num'])) ?></div>
    <div class="view_box">
        <div style="margin:-8px 0 10px 10px; float: right;height:30px">
            <!-- Baidu Button BEGIN -->
            <div id="bdshare" class="bdshare_t bds_tools get-codes-bdshare">
                <span class="bds_more">分享到：</span>
                <a class="bds_qzone"></a>
                <a class="bds_tsina"></a>
                <a class="bds_tqq"></a>
                <a class="bds_renren"></a>
                <a class="shareCount"></a>
            </div>
            <script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=600886" ></script>
            <script type="text/javascript" id="bdshell_js"></script>
            <script type="text/javascript">document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + new Date().getHours();</script>
            <!-- Baidu Button END -->
        </div>
        <div class="clear"></div>
    </div>

    <?php if ($event_data['album']): ?>
        <div class="view_title"><span class="middle"><img src="/static/images/ico_pic.gif"></span>活动掠影</div>
        <div class="view_box">
            <?php if (!$event_data['photos']): ?>
                <span class="nodata">暂时还没有照片。</span>
            <?php else: ?>
                <div>
                    <?php foreach ($event_data['photos'] as $p): ?>
                        <?php $link = URL::site('album/picView?id=' . $p['id']) ?>
                        <div class="pbox">
                            <a href="<?= $link ?>" title="点击放大" target="_blank">
                                <img src="<?= URL::base() . $p['img_path'] ?>" />
                            </a>
                            <br />
                            <a href="<?= $link ?>" title="点击放大" target="_blank"><?= Text::limit_chars($p['name'], 10) ?></a>
                        </div>
                    <?php endforeach; ?>
                    <div class="clear"></div>
                </div>
            <?php endif; ?>

        </div>
    <?php endif; ?>

    <div class="view_title"><span ><img src="/static/images/ico_users.gif"></span>&nbsp;&nbsp;报名信息(<?= $event_data['total_sign'] ?>人)</div>
    <div class="view_box">

        <?php if (count($event_data['signs']) == 0): ?>
            <span class="nodata">暂时还没有人报名。</span>
        <?php else: ?>

                <?php if ($event_data['permission']['is_edit_permission'] OR (isset($event_data['sign_category']) AND $event_data['sign_category'])): ?>
                    <table cellspan="0" border="0" style="width:98%; height: 25px; margin-top: -15px; margin-bottom: 15px">
                        <tr>
                            <td style=" text-align:left;width:30%">
                                <?php if ($event_data['permission']['is_edit_permission']): ?><img src="/static/images/page_excel.gif"  style=" vertical-align: middle" />&nbsp; <a href="/event/signDownload?eid=<?=$event_data['event']['id']?>">下载名单</a>  <?php endif; ?>
                            </td>
                            <td style=" text-align: right;width:60%">
                                <?php if (isset($event_data['sign_category']) AND $event_data['sign_category']): ?>
                                    <select id="category_id" name="category_id" onchange=" $('#manageGroup').html('');changeSignGroup(this.value,<?=$event_data['event']['id']?>);">
                                        <option style="color:#999">按分组查看...</option>
                                        <option value="all" >全部名单&nbsp;&nbsp;(<?= $event_data['total_sign'] ?>)</option>
                                        <?php foreach ($event_data['sign_category'] as $id => $c): ?>
                                            <option value="<?= $c['id'] ?>"><?= $c['name'] ?><?= isset($c['User']['realname'])?' — 队长'.$c['User']['realname']:null;?>&nbsp;&nbsp;(<?= $c['sign_num'] ? $c['sign_num'] : '0' ?>人)</option>
                                        <?php endforeach; ?>
                                    </select>
                                <?php endif; ?></td>
                        </tr>
                    </table>
                <?php endif; ?>

            <div style="width:100%" id="event_signs">
<?= View::factory('event/inc_signs',array('signs'=>$event_data['signs'],'permission'=>$event_data['permission'])) ?>

                <div class="clear"></div>
            </div>
        <?php endif; ?>

         <div id="manageGroup" style=" clear: both">
         </div>

    </div>
    <div id="scrollToComment" style="height:5px"></div>
    <div class="view_title" ><span class="middle"><img src="/static/images/comments.png"></span>评论(<?= $event_data['event']['comments_num'] ?>)</div>
    <div class="view_box">

        <!--回复及评论 -->
        <?php
        $cmtParams['event_id'] = $event_data['event']['id'];
        if ($event_data['event']['bbs_unit_id']) {
            $cmtParams['bbs_unit_id'] = $event_data['event']['bbs_unit_id'];
        }
        ?>
        <?= View::factory('inc/comment/newform', array('params' => $cmtParams)) ?>
        <!--//回复及评论 -->
    </div>

    <?php if ($event_data['permission']['is_edit_permission']): ?>
    <?php endif; ?>
<?php endif; ?>
