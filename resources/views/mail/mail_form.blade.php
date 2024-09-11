<table class="mail_form" border="0">
    <tr>
        <th colspan="2">문의하신 고객님의 비밀번호를 보내드립니다. 로그인하시고 반드시 비밀번호를 변경하세요.</th>
    </tr>
    <tr>
        <th>아이디</th>
        <td>{{ $data_arr['toemail'] }}</td>
    </tr>
    <tr>
        <th>신규 비밀번호</th>
        <td><?php echo nl2br($data_arr['content']); ?></td>
    </tr>
</table>