$results = @();

Get-ChildItem -Filter "*.cer" | % {
    $test = openssl x509 -inform pem -in $_.FullName -noout -enddate;
    if (-not $test) {
        $test = openssl x509 -inform der -in $_.FullName -noout -enddate;
    }
    
    $test = $test.Replace("notAfter=", "");
    $test = $test.Replace("GMT", "");
    $test = date --date="$test" --utc +"%Y-%m-%d %H:%M:%S";

    $result = @{
        partnerId = $_.BaseName
        expirationDate = $test
    }
    $results += New-Object PSObject -Property $result;
}

$results | export-csv -Path "certificateExpirations.csv" -NoTypeInformation -Encoding UTF8