<?php if ($error): ?>
    <div style="padding: 15px;color:#f30;width:480px; line-height: 1.6em"><span><?= $error ?></span></div>
<?php else: ?>

    <form id="sign_form" name="sign_form" action="<?= URL::site('event/sign') ?>" method="post" >
        <table  border="0" cellspacing="3" cellpadding="0" style="margin-top:0px;width:480px">
            <tr>
                <td  style="width:18%;text-align: right;padding-right: 5px;">参加人数：</td>
                <td >
                    <?php $maxnum = $event['maximum_entourage'] ? $event['maximum_entourage'] : 10; ?>
                    <select name="num">
                        <?php for ($i = 1; $i <= $maxnum; $i++): ?>
                            <option value="<?= $i ?>" <?= isset($user_sign['num']) && $user_sign['num'] == $i ? 'selected' : ''; ?>> <?= $i ?> </option>
                        <?php endfor; ?>
                    </select>&nbsp;&nbsp;<span style="color:#999">人</span></td>
            </tr>

            <?php if ($event['need_tickets']): ?>
                <tr>
                    <td style="text-align: right;padding-right: 5px">门票：</td>
                    <td colspan="2">
                        <select name="tickets">
                            <?php for ($i = 1; $i <= $event['maximum_receive']; $i++): ?>
                                <option value="<?= $i ?>" <?= isset($user_sign['tickets']) && $user_sign['tickets'] == $i ? 'selected' : ''; ?>><?= $i ?></option>
                            <?php endfor; ?>
                        </select>
                        &nbsp;&nbsp;<span style="color:#999">张</span></td>
                </tr>
            <?php endif; ?>

            <?php if ((!empty($event['receive_address'])) && $event['need_tickets']): ?>
                <?php
                $receive_address = explode("\n", trim($event['receive_address']));
                ?>
                <tr>
                    <td style="text-align: right;padding-right: 5px">领票位置：</td>
                    <td colspan="2">
                        <select name="receive_address">
                            <?php foreach ($receive_address as $address): ?>
                                <option value="<?= $address ?>" <?= isset($user_sign['receive_address']) && $user_sign['receive_address'] == $address ? 'selected' : ''; ?>><?= $address ?></option>
                            <?php endforeach; ?>
                        </select></td>
                </tr>
            <?php endif; ?>

            <?php if ($event['category_label']): ?>
                <tr>
                    <td style="text-align: right;padding-right: 5px"><?= $event['category_label'] ?>：</td>
                    <td colspan="2">
                        <select name="category_id" id="category_id">
                            <option value="0">选择...</option>
                            <?php if($event['is_create_procession']): ?>
                                <option value="" style="color:green">创建我的队伍</option>                   
                            <?php endif; ?>
                            <?php foreach ($categorys as $id => $c): ?>
                                <option value="<?= $c['id'] ?>" <?= isset($user_sign['category_id']) && $user_sign['category_id'] == $c['id'] ? 'selected' : ''; ?>><?= Text::limit_chars($c['name'], 16, '...') ?><?= isset($c['User']['realname'])?' — 队长'.$c['User']['realname']:null;?>&nbsp;&nbsp;(<?= $c['sign_num'] ? $c['sign_num'] : '0' ?>人)</option>
                            <?php endforeach; ?>
                        </select></td>
                </tr>
            <?php endif; ?>
            <tr>
                <td style="text-align: right;padding-right: 5px">备注：</td>
                <td colspan="2"><textarea name="remarks" style="width:300px;height:50px; color: #666" class="input_text" <?php if (!isset($user_sign['id'])): ?>onFocus="this.value = ''"  onblur="if(this.value == ''){
                                this.value = '没啥说的，一定准时到场～'
                            }"<?php endif; ?>><?= isset($user_sign['remarks']) ? $user_sign['remarks'] : '没啥说的，一定准时到场～'; ?></textarea>
                        <input type="hidden" name="event_id" value="<?= $event['id'] ?>">
        <input type="hidden" name="sign_action" value="<?= isset($user_sign['id']) ? 'update' : 'add'; ?>">
                </td>
            </tr>
            <tr>
                <td style="text-align: right;padding-right: 5px"></td>
                <td colspan="2" style="color:#999"><span style="vertical-align: middle"><input type="checkbox" name="is_anonymous" id="is_anonymous" value="1"   <?= isset($user_sign['is_anonymous']) && $user_sign['is_anonymous'] ? 'checked' : ''; ?>></span><label for="is_anonymous">匿名参加</label></td>
            </tr>

            <?php if (isset($user_sign['id'])): ?>
                <tr>
                    <td style="text-align: right;padding-right: 5px"></td>
                    <td colspan="2" style="color:#999; padding-top: 6px"><a href="javascript:cancel_sign(<?= $event['id'] ?>)" style="color:#F78993">取消报名？</a></td>
                </tr>
            <?php endif; ?>
        </table>
    </form>
    
<div id="sign_formstatusTools" style="clear:both;margin:5px;padding:5px;"></div>

<?php endif; ?>
<?php if($event['is_create_procession']): ?>

<script type="text/javascript">
                $(document).ready(function() {
                    var captain = $('#category_id');
                    captain.change(function() {
                        if (captain.val() === '') {
                            window.event_category_facebox = new Facebox({
                                id: 'eventcagegorys',
                                title: '创建我的队伍',
                                width: '500px',
                                top: '55%',
                                left: '55%',
                                url: '/event/signCategoryForm?event_id=<?= $event['id'] ?>',
                                okVal: false,
                                ok: false,
                                cancel: 'hidden'
                            }).show();
                        }
                    });
                });
</script>
<?php endif; ?>