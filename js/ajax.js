function ajax(url, bloc)
   {
   var req = false;

   if(window.XMLHttpRequest)
      {
      req = new XMLHttpRequest();
      if (req.overrideMimeType)
         {
         req.overrideMimeType("text/xml");
         }
      }
   else
      {
      if (window.ActiveXObject)
         {
         try
            {
            req = new ActiveXObject("Msxml2.XMLHTTP");
            }
         catch (e)
            {
            try
               {
               req = new ActiveXObject("Microsoft.XMLHTTP");
               }
            catch (e)
               {
               alert('Problème');                  
               }
            }
         }
      }
   if (req)
      {
        req.onreadystatechange = function()
           {
           if (req.readyState == 4)
              {
              if (req.status == 200)
                 {
                  var d = document.getElementById(bloc);
                  d.innerHTML = req.responseText;
                 }
              else
                 {
                  alert('Problème');
                 }
              }
           }
        req.open('GET', url, true);
        req.send(null);
      }
	}

function ajax_post(page,v,redirection,bloc) // fonction qui envoie des variables avec la méthode POST
   {
   var requete = false;
   if(window.XMLHttpRequest)
     {
     requete = new XMLHttpRequest();
     if (requete.overrideMimeType)
        {
        requete.overrideMimeType("text/xml");
        }
     }
  else
     {
     if (window.ActiveXObject)
        {
        try
           {
           requete = new ActiveXObject("Msxml2.XMLHTTP");
           }
        catch (e)
           {
           try
              {
              requete = new ActiveXObject("Microsoft.XMLHTTP");
              }
           catch (e)
              {
              alert('Problème');                  
              }
           }
        }
     }
    if (requete)
     {
     requete.onreadystatechange = function()
            {
            if (requete.readyState == 4)
               {
               if (requete.status == 200)
                  {
                   if (redirection!="") 
                     {
                     document.location.href=redirection;
                     }
                   else
                     {
                     var d = document.getElementById(bloc);
                     d.innerHTML = requete.responseText;
                     }
                  }
               else
                  {
                   alert('Problème');
                  }
               }
            }
     
     requete.open("POST",page);
     requete.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
     requete.send(v);
     }
   }


