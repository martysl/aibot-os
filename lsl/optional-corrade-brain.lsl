//you can use also corrade for this so bot

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Settings
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
 
string  gCORRADE  = "";   // Your Corrade Bot's UUID Key
string  gGROUP    = "";                             // Bot's Group Name as defined in the ini File
string  gPASSWORD = "";                         // Bot's Password as defined in the ini File
string owner; 
string answer;
string target = "!t"; //your keyword
string password = ""; //your password here
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Functions
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

 
string wasKeyValueEncode(list kvp)
{
  if(llGetListLength(kvp) < 2) return "";
  string k = llList2String(kvp, 0);
  kvp      = llDeleteSubList(kvp, 0, 0);
  string v = llList2String(kvp, 0);
  kvp      = llDeleteSubList(kvp, 0, 0);
  if(llGetListLength(kvp) < 2) return k + "=" + v;
  return k + "=" + v + "&" + wasKeyValueEncode(kvp);
}
 
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// States
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
string who;
list listname;
string name;
default
{
  state_entry()
  {
    if(llGetObjectDesc()=="Offline"){} else {
    llListen(0, "", "", "");
  }
  }
  listen(integer channel, string name, key id, string message)
  {
    if (id == gCORRADE || message == "") return;
    message = llToLower(message); // Convert message to lowercase
    if (llSubStringIndex(message, target) != -1) {
    message = llDeleteSubString(message, 0, 6);
    who = llGetDisplayName(id);
    listname=llParseString2List(who,[" "],[]);
    name2 = llList2String(listname, 0);
    if (name2 == "") {
    name2 = name;
    }
    string url = "https://yourapiurl/slai.php";
    string prompt = message;
    string user_channel = (string)id + "_" + channelid;
    string tQUERY =  "password=" password + "&uuid=" + user_channel + "&channelid=" + channelid + "&prompt=" + name2 + ":" + " " + prompt;
    llHTTPRequest(url, [HTTP_METHOD, "POST", HTTP_MIMETYPE, "application/x-www-form-urlencoded", HTTP_BODY_MAXLENGTH, 16384], postData);
    }
    }
 
  http_response(key request_id, integer status, list metadata, string body)
  {
   answer = body;

    llInstantMessage(gCORRADE, wasKeyValueEncode([
      "command",  "tell",
      "group",    llEscapeURL(gGROUP),
      "password", llEscapeURL(gPASSWORD),
      "entity",   "local",
      "type",     "Normal",
      "message",  llEscapeURL(answer)
    ]));
  }
}
