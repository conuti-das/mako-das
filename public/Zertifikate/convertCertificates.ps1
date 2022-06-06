Get-ChildItem -Filter "*.cer" | % {
    Start-Process -NoNewWindow -FilePath "C:\Program Files\Git\usr\bin\openssl.exe" -ArgumentList ("x509 -inform der -in """ + $_.FullName + """ -out """ + $_.FullName + ".converted""") | Out-Null;
    Start-Process -NoNewWindow -FilePath "C:\Program Files\Git\usr\bin\openssl.exe" -ArgumentList ("x509 -inform pem -in """ + $_.FullName + """ -out """ + $_.FullName + ".converted""") | Out-Null;
    
    return;
    Write-Host $_.FullName
    Write-Host "DER conversion... " -NoNewLine
    $result = 
    if ($result.ExitCode -eq 1) {
        Write-Host "success."
        return;
    }
    Write-Host "fail."
    Write-Host "PEM conversion... " -NoNewLine
    
    if ($result.ExitCode -eq 1) {
        Write-Host "success."
        return;
    }
    Write-Host -ForegroundColor Red "Fail."
}