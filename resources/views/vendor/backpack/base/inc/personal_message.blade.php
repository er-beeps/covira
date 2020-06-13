@php 
if(!backpack_user()){
  $responseId = request()->session()->get('response_id');
  $data = \App\Models\Response::where('id',$responseId)->get();

  $local_level_code = $data[0]->locallevel->code;
  $cri = $data[0]->covid_risk_index;
  $pci = $data[0]->probability_of_covid_infection;
  $rtr = DB::table('dt_risk_transmission')->where('code',$local_level_code)->pluck('ctr')->first();
}
@endphp

@if($cri > 20 && $rtr < 20)

<span>बेलाबेलामा साबुन पानीले कम्तिमा २० सेकेन्ड मिचिमिचि हात धुने वा अल्कोहल भएको स्यानिटाइजर प्रयोग गर्ने। बाहिर निस्कँदा मास्कको प्रयोग गर्ने।
संक्रमित ब्यक्तिहरुको सम्पर्कमा पुगेको अबस्थामा आफुलाई तुरुन्तै आइसोलेट गर्ने। लक्षणहरु बिचार गर्ने, यदि देखिएमा तुरुन्त स्वास्थ्य संस्थामा खबर गरि सल्लाह लिने।
खोक्दा हाछ्रयुँ गर्दा नाक मुख टिस्यू पेपर वा कुहिनाले छोप्ने र प्रयोग गरेको टिस्यू पेपरलार्इ बिर्को भएको फोहर फाल्ने भाँडोमा फाल्ने र साबुन पानीले मिचिमिचि हात धुने वा
अल्कोहल भएको स्यानिटाइजर प्रयोग गर्ने । खानेकुराहरु राम्रोसँग पकाएर मात्र खाने ।</span>


@elseif($cri < 20 && $rtr < 20)

@endif