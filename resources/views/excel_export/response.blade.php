<html>

<body>

    <div class="main">
        <table width="100%" style="margin-bottom: 50px;">
            <thead>
                <tr>
                    <th style="font-weight: bold; background-color:#e6e7eb; text-align: center" >S.N</th>
                    <th style="font-weight: bold; background-color:#e6e7eb; text-align: center" >Code</th>
                    <th style="font-weight: bold; background-color:#e6e7eb; text-align: center" >Name (Eng)</th>
                    <th style="font-weight: bold; background-color:#e6e7eb; text-align: center" >Name (Nep)</th>
                    <th style="font-weight: bold; background-color:#e6e7eb; text-align: center" >Gender</th>
                    <th style="font-weight: bold; background-color:#e6e7eb; text-align: center" >Age</th>
                    <th style="font-weight: bold; background-color:#e6e7eb; text-align: center" >Email</th>

                    <th style="font-weight: bold; background-color:#e6e7eb; text-align: center" >Is from Other Country</th>
                    <th style="font-weight: bold; background-color:#e6e7eb; text-align: center" >Country</th>
                    <th style="font-weight: bold; background-color:#e6e7eb; text-align: center" >City</th>
                    <th style="font-weight: bold; background-color:#e6e7eb; text-align: center" >Province</th>
                    <th style="font-weight: bold; background-color:#e6e7eb; text-align: center" >District</th>
                    <th style="font-weight: bold; background-color:#e6e7eb; text-align: center" >Local Level</th>
                    <th style="font-weight: bold; background-color:#e6e7eb; text-align: center" >Ward number</th>
                    <th style="font-weight: bold; background-color:#e6e7eb; text-align: center" >Education</th>
                    <th style="font-weight: bold; background-color:#e6e7eb; text-align: center" >Profession</th>
                    <th style="font-weight: bold; background-color:#e6e7eb; text-align: center" >GPS Latitude</th>
                    <th style="font-weight: bold; background-color:#e6e7eb; text-align: center" >GPS Longitude</th>

                    <th style="font-weight: bold; background-color:#e6e7eb; text-align: center" >Occupation</th>
                    <th style="font-weight: bold; background-color:#e6e7eb; text-align: center" >Exposure</th>
                    <th style="font-weight: bold; background-color:#e6e7eb; text-align: center" >Safety Measure</th>
                    <th style="font-weight: bold; background-color:#e6e7eb; text-align: center" >Habits</th>
                    <th style="font-weight: bold; background-color:#e6e7eb; text-align: center" >Existing Health Condition</th>
                    <th style="font-weight: bold; background-color:#e6e7eb; text-align: center" >Symptoms</th>

                    <th style="font-weight: bold; background-color:#e6e7eb; text-align: center" >Community Situation</th>
                    <th style="font-weight: bold; background-color:#e6e7eb; text-align: center" >Economic Impact</th>
                    <th style="font-weight: bold; background-color:#e6e7eb; text-align: center" >Neighbour Proximity</th>
                    <th style="font-weight: bold; background-color:#e6e7eb; text-align: center" >Confirmed Case</th>
                    <th style="font-weight: bold; background-color:#e6e7eb; text-align: center" >Inbound Foreign Travel</th>
                    <th style="font-weight: bold; background-color:#e6e7eb; text-align: center" >Community Population</th>
                    <th style="font-weight: bold; background-color:#e6e7eb; text-align: center" >Hospital Proximity</th>
                    <th style="font-weight: bold; background-color:#e6e7eb; text-align: center" >Corona Centre Proximity</th>
                    <th style="font-weight: bold; background-color:#e6e7eb; text-align: center" >Health Facility</th>
                    <th style="font-weight: bold; background-color:#e6e7eb; text-align: center" >Market Proximity</th>
                    <th style="font-weight: bold; background-color:#e6e7eb; text-align: center" >Food Stock</th>
                    <th style="font-weight: bold; background-color:#e6e7eb; text-align: center" >Agri Producer Seller</th>
                    <th style="font-weight: bold; background-color:#e6e7eb; text-align: center" >Product Selling Price</th>
                    <th style="font-weight: bold; background-color:#e6e7eb; text-align: center" >Commodity Availability</th>
                    <th style="font-weight: bold; background-color:#e6e7eb; text-align: center" >Commodity Price Difference</th>
                    <th style="font-weight: bold; background-color:#e6e7eb; text-align: center" >Job Status</th>
                    <th style="font-weight: bold; background-color:#e6e7eb; text-align: center" >Sustainability duration</th>
                    <th style="font-weight: bold; background-color:#e6e7eb; text-align: center" >Age risk factor</th>
                    <th style="font-weight: bold; background-color:#e6e7eb; text-align: center" >COVID Risk Index</th>
                    <th style="font-weight: bold; background-color:#e6e7eb; text-align: center" >Probability of COVID Infection</th>
               
                </tr>

            </thead>
            <tbody>
                @foreach ($datas as $data)
                <tr>
                    <td style="text-align: center">{{ $data['rnum'] }}</td>
                    <td style="text-align: center">{{ $data['code'] }}</td>
                    <td style="text-align: center">{{ $data['english_name'] }}</td>
                    <td style="text-align: center">{{ $data['nepali_name'] }}</td>
                    <td style="text-align: center">{{ $data['gender'] }}</td>
                    <td style="text-align: center">{{ $data['age'] }}</td>
                    <td style="text-align: center">{{ $data['email'] }}</td>
                    @if($data['is_other_country'])
                    <td style="text-align: center">True</td>
                    @else
                    <td style="text-align: center">False</td>
                    @endif
                    <td style="text-align: center">{{ $data['country'] }}</td>
                    <td style="text-align: center">{{ $data['city'] }}</td>
                    <td style="text-align: center">{{ $data['province'] }}</td>
                    <td style="text-align: center">{{ $data['district'] }}</td>
                    <td style="text-align: center">{{ $data['local_level'] }}</td>
                    <td style="text-align: center">{{ $data['ward_number'] }}</td>
                    <td style="text-align: center">{{ $data['education'] }}</td>
                    <td style="text-align: center">{{ $data['profession'] }}</td>
                    <td style="text-align: center">{{ $data['gps_lat'] }}</td>
                    <td style="text-align: center">{{ $data['gps_long'] }}</td>
                    <td style="text-align: center">
                    @if(isset($data['activity']))
                        @php 
                        $occ = [1,2,3,4,5,6,7,8,9,10,11,12,13];
                        @endphp
                        @foreach($data['activity'] as $key=>$act)
                            @if(in_array($key,$occ))
                                {{$act}}
                            @else
                                
                            @endif
                        @endforeach
                    @else
                        -
                    @endif
                    </td>

                    <td style="text-align: center">
                    @if(isset($data['activity']))
                        @php $exposure = [14,15,16,17,18,19,20,21,22]; @endphp
                        @foreach($data['activity'] as $key=>$act)
                            @if(in_array($key,$exposure))
                            {{$act}}
                            @else
                                
                            @endif
                        @endforeach
                    @else
                        -
                    @endif
                    </td>

                    <td style="text-align: center">
                    @if(isset($data['activity']))
                        @php $safety_measure = [23,24,25,26,27]; @endphp
                        @foreach($data['activity'] as $key=>$act)
                            @if(in_array($key,$safety_measure))
                            {{$act}}<br/>
                            @else
                                
                            @endif
                        @endforeach
                    @else
                        -
                    @endif
                    </td>

                    <td style="text-align: center">
                    @if(isset($data['activity']))
                        @php $habits = [28,29,30,31]; @endphp
                        @foreach($data['activity'] as $key=>$act)
                            @if(in_array($key,$habits))
                            {{$act}}<br/>
                            @else
                                
                            @endif
                        @endforeach
                    @else
                        -
                    @endif
                    </td>

                    <td style="text-align: center">
                    @if(isset($data['activity']))
                        @php $health = [32,33,34,35,36,37,38,39,40]; @endphp
                        @foreach($data['activity'] as $key=>$act)
                            @if(in_array($key,$health))
                            {{$act}}<br/>
                            @else
                                
                            @endif
                        @endforeach
                    @else
                        -
                    @endif
                    </td>

                    <td style="text-align: center">
                    @if(isset($data['activity']))
                        @php $symptom = [41,42,43,44,45,46,47,48,49,50,51,52,53,54]; @endphp
                        @foreach($data['activity'] as $key=>$act)
                            @if(in_array($key,$symptom))
                            {{$act}}<br/>
                            @else
                                
                            @endif
                        @endforeach
                    @else
                        -
                    @endif
                    </td>

                    <td style="text-align: center">{{ $data['community_situation'] }}</td>
                    <td style="text-align: center">{{ $data['economic_impact'] }}</td>
                    <td style="text-align: center">{{ $data['neighbour_proximity'] }}</td>
                    <td style="text-align: center">{{ $data['confirmed_case'] }}</td>
                    <td style="text-align: center">{{ $data['inbound_foreign_travel'] }}</td>
                    <td style="text-align: center">{{ $data['community_population'] }}</td>
                    <td style="text-align: center">{{ $data['hospital_proximity'] }}</td>
                    <td style="text-align: center">{{ $data['corona_centre_proximity'] }}</td>
                    <td style="text-align: center">{{ $data['health_facility'] }}</td>
                    <td style="text-align: center">{{ $data['market_proximity'] }}</td>
                    <td style="text-align: center">{{ $data['food_stock'] }}</td>
                    <td style="text-align: center">{{ $data['agri_producer_seller'] }}</td>
                    <td style="text-align: center">{{ $data['product_selling_price'] }}</td>
                    <td style="text-align: center">{{ $data['commodity_availability'] }}</td>
                    <td style="text-align: center">{{ $data['commodity_price_difference'] }}</td>
                    <td style="text-align: center">{{ $data['job_status'] }}</td>
                    <td style="text-align: center">{{ $data['sustainability_duration'] }}</td>
                    <td style="text-align: center">{{ $data['age_risk_factor'] }}</td>
                    <td style="text-align: center">{{ $data['covid_risk_index'] }}</td>
                    <td style="text-align: center">{{ $data['probability_of_covid_infection'] }}</td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>