$(document).ready(function () {
    $.urlParam = function (name) {
        try {

            var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
            return results[1] || 0;
        } catch {
            return null;
        }
    }
    $('#district').append('<option value="">--जिल्ला--</option>');
    $('#local_level').append('<option value="">--स्थानीय तह--</option>');

    $('#province').on('change', function () {
        var stateID = $(this).val();


        $('#district').append('<option value="">-- Loading...  --</option>');

        if (stateID) {
            $.ajax({
                url: '/district/' + stateID,
                type: "GET",
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function (data) {

                    if (data) {
                        $('#district').empty();
                        $('#local_level').empty();
                        $('#district').focus;
                        $('#district').append('<option value="">-- जिल्ला छान्नुहोस्  --</option>');
                        var selected_id = $.urlParam("district");

                        $.each(data, function (key, value) {
                            var selected = "";
                            if (selected_id == value.id) {
                                selected = "SELECTED";
                            }

                            $('select[name="district"]').append('<option class="form-control nepali_td" value="' + value.id + '" ' + selected + '>' + value.code + '-' + value.name_lc + '-' + value.name_en + '</option>');
                            if (selected == "") {
                                $("#district").trigger("change");
                                $("#local_level").trigger("change");
                            }
                        });
                    } else {
                        $('#district').empty();
                        $('#local_level').empty();
                    }
                }
            });
        } else {
            $('#district').empty();
            $('#local_level').empty();
        }
    });

    $('#district').on('change', function () {
        var districtID = $(this).val();
        if (districtID) {
            $('#local_level').append('<option value="">-- Loading...  --</option>');
            $.ajax({
                url: '/local_level/' + districtID,
                type: "GET",
                data: {
                    "_token": "{{ csrf_token() }}"
                },

                dataType: "json",
                success: function (data) {
                    if (data) {
                        $('#local_level').empty();
                        $('#local_level').focus;
                        $('#local_level').append('<option value="">-- स्थानीय तह  छान्नुहोस् --</option>');
                        var selected_id = $.urlParam("local_level");
                        $.each(data, function (key, value) {
                            var selected = "";
                            if (selected_id == value.id) {
                                selected = "SELECTED";
                            }
                            $('select[name="local_level"]').append('<option class="form-control nepali_td" value="' + value.id + '" ' + selected + '>' + value.code + '-' + value.name_lc + '-' + value.name_en + '</option>');
                            if (selected == "") {
                                $("#local_level").trigger("change");
                            }
                        });
                    } else {
                        $('#local_level').empty();
                    }
                }
            });
        } else {
            $('#local_level').empty();
        }
    });
    $("#province").trigger("change");
});


