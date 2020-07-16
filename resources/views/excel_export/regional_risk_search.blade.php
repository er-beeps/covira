<html>

<body>

    <div class="main">
        <table width="100%" style="margin-bottom: 50px;">
            <thead>
                <tr>
                    <th style="font-weight: bold; background-color:#e6e7eb; text-align: center" >S.N</th>
                    <th style="font-weight: bold; background-color:#e6e7eb; text-align: center" >Province (Eng)</th>
                    <th style="font-weight: bold; background-color:#e6e7eb; text-align: center" >Province (Nep)</th>
                    <th style="font-weight: bold; background-color:#e6e7eb; text-align: center" >District (Eng)</th>
                    <th style="font-weight: bold; background-color:#e6e7eb; text-align: center" >District (Nep)</th>
                    <th style="font-weight: bold; background-color:#e6e7eb; text-align: center" >Local Level (Eng)</th>               
                    <th style="font-weight: bold; background-color:#e6e7eb; text-align: center" >Local Level (Nep)</th>               
                    <th style="font-weight: bold; background-color:#e6e7eb; text-align: center" >Date</th>               
                    <th style="font-weight: bold; background-color:#e6e7eb; text-align: center" >Time</th>               
                </tr>

            </thead>
            <tbody>
                @foreach ($datas as $data)
                <tr>
                    <td style="text-align: center">{{ $data->rnum }}</td>
                    <td style="text-align: center">{{ $data->province_eng }}</td>
                    <td style="text-align: center">{{ $data->province_nep }}</td>
                    <td style="text-align: center">{{ $data->district_eng }}</td>
                    <td style="text-align: center">{{ $data->district_nep }}</td>
                    <td style="text-align: center">{{ $data->locallevel_eng }}</td>
                    <td style="text-align: center">{{ $data->locallevel_nep }}</td>
                    <td style="text-align: center">{{ $data->date }}</td>
                    <td style="text-align: center">{{ $data->time }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>