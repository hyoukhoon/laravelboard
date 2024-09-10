<table class="mail_form" border="0">
    <tr>
        <th>제목</th>
        <td>{{ $data_arr['subject'] }}</td>
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