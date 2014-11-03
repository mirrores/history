<form id="wish_form" method="post" action="/wedding/wishform?id=<?=$wedding['id']?>">
    <table>
        <tr>
            <td>
                <textarea name="content" style="width:400px; height: 100px"></textarea>
            </td>
        </tr>
        <tr>
            <td style="text-align: right">
                <input type="hidden" name="wedding_id" value="<?= $wedding['id'] ?>" />
            </td>
        </tr>
    </table>
    <input type="submit" value="保存" style="display: none" />
</form>
