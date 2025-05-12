# Shapes Bot SL/OS  
#⚙️ Setup Instructions  
## 1. Clone the Repository  
```
git clone https://github.com/martysl/shapes-aibot-slos
cd shapes-aibot-slos
```
## 2. Deploy LSL Scripts in OpenSim/Second life  
Create an Object: In your OpenSim/Second life environment, create a new object (e.g., a prim).  
Add LSL Script: Open the object's script editor and paste the contents of lsl/brain-sl-object.lsl remember to put url to your api backend.  

Configure Script: Ensure the script contains the correct URL pointing to your PHP backend.  

## 3.Set Up the PHP Backend  
Web Server: Ensure you have a web server (e.g., Apache or Nginx) with PHP support.  

Deploy PHP Scripts: Copy the contents of the php/ directory to your web server's root or a subdirectory and put apikey in config.php and model in api.php file.  

## 4. Optional: Integrate Corrade Bot  
If you wish to enhance the bot's capabilities using Corrade:  

Set Up Corrade: Follow the Corrade setup guide to deploy the Corrade bot in your OpenSim/secondlife environment.  

Configure lsl Script: use optional-corrade-brain instead of object one and fill needed config to communicate with Corrade by sending appropriate commands. not forgot to set api url.  

Here you can download [corrade](http://grimore.org/secondlife/scripted_agents/corrade)  
## What bot can
- [x] Read prompt on local chat 
- [x] Send reply on local chat
- [x] Generate Image based on prompt (you need say make image)
## What is not in current version:  
- [ ] Bot not have automatic upload sounds to second life/opensimulator just send mp3 link (this probably never will work that way)  
- [ ] Bot not put texture on prim just say a link in local chat (opensim can implement this, second life no)  
- [ ] Cant send audio to api even via link
- [ ] max resonse text is only 250 characters (limits of second life/opensim)
## what i wish to add someday with free time
- To shape be able to make a song with response on prompt and some api (hopefully can find free) 
- Use dynamic texture to automatic put image on prim
- To let user send mp3 link to let shape transcribe it to text 
- Longer response, other processing response
- player for voice of shape on moap

## What You need to remember:
In shape settings 
- in your shape personality tell your shape responses can be max 250 characters  
- in your shape personality tell your shape every prompt she got start from name of person what is "Name:"  
In php:
- configure API key  
- configure shape model example: shapeinc/username (of course put yours shape handle:) )
- configure passowrd for api (should be other than connector)
- configure passowrd for connector
in LSL:
- set prefix
- set channel id (can be name or number up to you)
- set url of api
- set password to connector 
## Usage:
to use just say !prefix and your prompt, prefix you can cofigure in lsl.  
Example:
```
!t hi how are you.
```
>[!NOTE]
> shape will response on local chat (shape cant respond to im even via corrade)
  
>[!WARNING]
> Shape not listen all local chat only this part where is prefix (u can change prefix but not remove this limiter, it will break it.
___

Api for this bot is made by [shapes.inc](https://shapes.inc/) and thanks them for that :)  
More info you can find on their page [shapes.inc](https://shapes.inc/)  
Api need api key from [here](https://shapes.inc/developer) and make your model on [here](https://shapes.inc/create).   
Also you can find them on [reddit](https://www.reddit.com/r/ShapesInc/)   

Have playing.  
[Marty](https://github.com/martysl/)  
see you around.  
PS. If need any help you can post issue here on github, contact Marty Mouse inside second life or on developer slack link will be in shapes.inc developer page [here](https://shapes.inc/developer).
