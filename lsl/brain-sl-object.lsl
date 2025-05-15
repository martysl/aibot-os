//if using object mode
string target = "!t"; //world of what it react
string owner; 
string answer;
key who;
string name;
string send;
list listname;
string password=""; //your password here
string channelid=""; //put here your channel name!
string StripOthers(string Input) {
    
    integer Counter = llStringLength(Input);
    string Whitelist = "ABCDEFGHIJKLMNOPQRSTUVWXYZ 0123456789";
    while (Counter--) {
        if (-1 == llSubStringIndex(Whitelist, llToUpper(llGetSubString(Input, Counter, Counter)))) {
            Input = llDeleteSubString(Input, Counter, Counter);
        }
    }
    return Input;
}
default {
  state_entry()
  {
   llListen(0, "", "", "");
   llListen(3, "", "", ""); //because we listen on local chat and private channel
  }
  listen(integer channel, string name, key id, string message)
  {
    if (id == llGetKey() || message == "") return;
    message = llToLower(message); // Convert message to lowercase
    if (llSubStringIndex(message, target) != -1) {
    message = llDeleteSubString(message, 0, 1);
    who = llGetDisplayName(id);
    string cleaned = StripOthers(who);
    listname=llParseString2List(cleaned,[" "],[]);
    string name2 = llList2String(listname, 0);
    if (name2 == "") {
    name2 = name;
    }
    send = name2 + ": " + message;
    string user_channel = (string)id + "_" + channelid;

    string tQUERY =  "password=" + password + "&uuid=" + user_channel + "&channelid=" + channelid + "&prompt="+llEscapeURL(send);
    string url = "https://urltoyourphp.com/slai.php";
    llHTTPRequest(url, [HTTP_METHOD, "POST", HTTP_MIMETYPE, "application/x-www-form-urlencoded", HTTP_BODY_MAXLENGTH, 16384], tQUERY);
    }
     }
     http_response(key request_id, integer status, list metadata, string body)
     {
     llSay(0,body);
    }
}
