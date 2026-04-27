$k='f655ba9d09a112d4968c63579db590b4'
$iv='98344c2eee86c3994890592585b49f80'
$c='c93747a94b54edf5ca4d13e520a65d0a'
function hex2bin([string]$h){
    $b = New-Object System.Collections.ArrayList
    for($i=0; $i -lt $h.Length; $i+=2){
        [void]$b.Add([Convert]::ToByte($h.Substring($i,2),16))
    }
    return ,($b.ToArray([Byte]))
}
$key = hex2bin $k
$ivb = hex2bin $iv
$ct = hex2bin $c
$aes = [System.Security.Cryptography.Aes]::Create()
$aes.Mode = [System.Security.Cryptography.CipherMode]::CBC
$aes.Padding = [System.Security.Cryptography.PaddingMode]::None
$aes.Key = $key
$aes.IV = $ivb
$dec = $aes.CreateDecryptor().TransformFinalBlock($ct,0,$ct.Length)
# manual PKCS7 unpad
if($dec.Length -gt 0){
    $pad = [int]$dec[$dec.Length - 1]
    if($pad -gt 0 -and $pad -le 16){
        $valid = $true
        for($i=1;$i -le $pad;$i++){ if($dec[$dec.Length - $i] -ne $pad){ $valid = $false; break } }
        if($valid){ $dec = $dec[0..($dec.Length - $pad - 1)] }
    }
}
$hex = -join ($dec | ForEach-Object { $_.ToString('x2') })
Write-Output $hex
