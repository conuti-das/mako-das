$(document).ready(function () {

    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }

    $('#certificationUploadModal').on('show.bs.modal', function () {
        $('#certificate_form_partnerId').val('');
        $('#certificate_form_uploadFile').val('');
        $('#certificate-information').addClass('d-none');
        $("#list-cert-information input:hidden").val("");
        $("#list-cert-information span").html("");
    })

    $("#certificateModal").click(function () {
        $("#certificate_form_partnerId").val("");
        $("#certificationUploadModal").modal('show');
    });

    $("#cancel-upload").click(function () {
        $("#certificationUploadModal").modal('hide');
    })

    $("#certificate_form_uploadFile").change(function (e) {
        const file = e.target.files[0];
        const form_data = new FormData();
        const certificateFormPartnerId = $('#certificate_form_partnerId').val();
        form_data.append('partnerId', certificateFormPartnerId)
        form_data.append('file', file, e.target.files[0].name);
        $.ajax({
            type: "POST",
            url: "/admin/certificates/decode",
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            dataType: "json",
            success: function (response) {
                if (!response.errorMessage) {
                    $('.successMsg').html('Certificate Decoded.');
                    $('#certificate-information').removeClass('d-none');
                    setTimeout(function(){ $('.certificate-success').css("display", "none");}, 2000);
                    let validFromDate = response.validFrom.date.split('.')[0];
                    let validUntilDate = response.validUntil.date.split('.')[0];
                    $("#certificate_form_email_hidden").html(response.emailAddress)
                    $("#certificate_form_certificateFile").val(response.certificateFile)
                    $("#certificate_form_email").val(response.emailAddress)
                    $("#certificate_form_validFrom_hidden").html(validFromDate)
                    $("#certificate_form_validFrom").val(validFromDate)
                    $("#certificate_form_validUntil_hidden").html(validUntilDate)
                    $("#certificate_form_validUntil").val(validUntilDate)
                    $("#certificate_form_issuerName").html(response.issuerName)
                    $("#certificate_form_name").html(response.name)
                    $("#certificate_form_hash").html(response.hash)
                    if (response.isActive) {
                        $("#certificate_form_isActive").html(response.isActive).addClass('badge bg-success');
                    } else {
                        $("#certificate_form_isActive").html(response.isActive).addClass('badge bg-danger');
                    }
                    $("#certificate_form_issuerCountry").html(response.issuerCountry)
                    $("#certificate_form_issuerOrganisation").html(response.issuerOrganisation)
                    $("#certificate_form_issuerOrganisationUnit").html(response.issuerOrganisationUnit)
                    $("#certificate_form_serialNumber").html(response.serialNumber)
                    $("#certificate_form_subjectCountry").html(response.subjectCountry)
                    $("#certificate_form_subjectLocation").html(response.subjectLocation)
                    $("#certificate_form_subjectName").html(response.subjectName)
                    $("#certificate_form_subjectOrganisation").html(response.subjectOrganisation)
                    if ($('#certificate_form_uploadFile').val()) {
                        $('#save-disable').removeAttr("disabled")
                        $('.form-group-hide').css("display", 'block')
                    }
                } else {
                    $('#certificate_form_uploadFile').val("")
                    $('#certificate_form_partnerId').val("")

                    $('#uploadCertErrorMessage').html(response.errorMessage);
                    $('#uploadCertErrorMessage').removeClass('d-none');
                    $("#uploadCertErrorMessage").fadeTo(2000, 500).slideUp(500, function(){
                        $("#uploadCertErrorMessage").slideUp(800);
                    });
                }
            },
            error: function (error) {
                console.log(error);
            }
        });
    })

    if($('#showSuccessMessage').val() == 1){
        $.growl.notice({
            title: "Success!",
            message: "Saved successfully!"
        });
        $('#showSuccessMessage').val("");
    }

    $('#certificateTable').DataTable({});
});
