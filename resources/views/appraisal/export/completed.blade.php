<table>
    <thead>
        <tr>
            <th style="text-align: center;"> NO </th>
            <th> NIK </th>
            <th> EMPLOYEE </th>
            <th> DEPARTMENT </th>
            <th> LEVEL </th>
            <th> MILESTONE RATING </th>
            <th> COMPETENCIES RATING </th>
            <th> JOB PERFORMANCE RATING </th>
            <th> FINAL SCORE </th>
            <th> CONFIDENTIAL SUMMARY </th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $key => $val)
            <tr>
                <td style="text-align: center;">{{ $key+1 }}</td>
                <td>{{ $val->user_nik }}</td>
                <td>{{ $val->user_name }}</td>
                <td>{{ $val->department_name }}</td>
                <td>{{ $val->grade_group_name }}</td>
                <td>{{ $val->overall_milestone_score }}</td>
                <td>{{ $val->overall_competency_score }}</td>
                <td>{{ $val->overall_performance_score }}</td>
                <td>{{ $val->final_score }}</td>
                <td>{{ $val->confidential_summary }}</td>
            </tr>
        @endforeach
    </tbody>
</table>