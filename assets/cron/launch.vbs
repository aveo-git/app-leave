Set WinScriptHost = CreateObject("WScript.Shell")
WinScriptHost.Run Chr(34) & "C:\wamp64\www\app-leave\assets\cron\script.bat" & Chr(34), 0
Set WinScriptHost = Nothing