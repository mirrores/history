<div id="main" style="background-color:#F8FCFF; " >
    
<p><img src="/static/images/xiaoyouvideo.jpg"></p>
<p style=" margin: 10px">校友讲堂 - 第十三讲开幕式</p>
<div style="width: 860px; margin: 10px auto">
    

    <video width="850" height="478"  controls autoplay >
        <!-- MP4 must be first for iPad! -->
        <source src="<?=$video['video_path']?>video.mp4" type="video/mp4"  /><!-- Safari / iOS, IE9 -->
        <source src="<?=$video['video_path']?>video.webm"  type="video/webm" /><!-- Chrome10+, Ffx4+, Opera10.6+ -->
        <source src="<?=$video['video_path']?>video.ogv"  type="video/ogg"  /><!-- Firefox3.6+ / Opera 10.5+ -->
        <!-- fallback to Flash: -->
        <object width="850" height="478" type="application/x-shockwave-flash" data="/static/video/player.swf">
            <!-- Firefox uses the `data` attribute above, IE/Safari uses the param below -->
            <param name="movie" value="/static/video/player.swf" />
            <param name="flashvars" value="autostart=false&amp;controlbar=over&amp;image=<?=$video['video_path']?>video.jpg&amp;file=<?=$video['video_path']?>video.mp4" />
            <!-- fallback image -->
            <img src="<?=$video['video_path']?>video.jpg" width="850" height="478"   />
        </object>
    </video>

</div>

        <p class="comments_title">评论</p>
        <div style="padding:10px">
            <!--回复及评论 -->
            <?= View::factory('inc/comment/newform', array('params' => array('video_id' => $video['id']))) ?>
            <!--//回复及评论 -->
        </div>
</div>