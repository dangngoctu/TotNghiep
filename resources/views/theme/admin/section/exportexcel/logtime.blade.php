<table>
    <thead>
    <tr>
        <td colspan="8">Thời gian logtime của nhân viên<h1></h1></td>
    </tr>
    <tr>
        <th>Name</th>
        <th>Login</th>
        <th>Logout</th>
        <th>Trạng thái</th>
        <th>Ngày tạo</th>
    </tr>
    </thead>
    <tbody>
    @foreach($list as $key => $val)
        <tr>
            <td>{{$val->m_user->name}}</td>
            <td>{{\Carbon\Carbon::parse($val->time_in)->format('Y-m-d H:i:s')}}</td>
            <td>{{\Carbon\Carbon::parse($val->time_out)->format('Y-m-d H:i:s')}}</td>
            <td>
                @php
                    $time = (strtotime($val->time_out)-strtotime($val->time_in))/60
                @endphp
                @if($time < 8)
                    Về sớm
                @elseif($time > 8 && $time < 9)
                    Đúng giờ
                @else
                    Về trễ
                @endif
            </td>
            <td>{{\Carbon\Carbon::parse($val->created_at)->format('Y-m-d H:i:s')}}</td>
        </tr>
    @endforeach
    </tbody>
</table>