Import-Csv .\market_partner_for_certificates_postman.csv | % {
    $_ | Add-Member -Name "sslCertificate" -MemberType NoteProperty -Value "";
    if (Test-Path ($_.partnerId + ".cer.converted")) {
        $_.sslCertificate = cat ($_.partnerId + ".cer.converted") | Out-String;
    }
    
    $_
} |
Export-Csv -Path .\test.csv -NoTypeInformation -Encoding UTF8