document.querySelector("#agregar-tarea").addEventListener("click",(function(){const e=document.createElement("DIV");e.classList.add("modal"),e.innerHTML='\n            <form class="formulario nueva-tarea">\n                <legend>Añade una nueva tarea</legend>\n                <div class="campo">\n                    <label>Tarea</label>\n                    <input type="text" name="tarea" placeholder="Añadir tarea al proyecto" id="tarea" />\n                </div>\n                <div class="opciones">\n                    <input type="submit" class="submit-nueva-tarea" value="Añadir Tarea" />\n                    <button type="button" class="cerrar-modal">Cancelar</button>\n                </div>\n            </form>\n        ',setTimeout(()=>{document.querySelector(".formulario").classList.add("animar")},0),e.addEventListener("click",(function(t){t.preventDefault(),t.target.classList.contains("cerrar-modal")&&(document.querySelector(".formulario").classList.add("cerrar"),setTimeout(()=>{e.remove()},500)),t.target.classList.contains("submit-nueva-tarea")&&function(){const e=document.querySelector("#tarea").value.trim();""!==e?async function(e){const t=new FormData;t.append("nombre","cintia");try{const e="http://localhost:3000/api/tarea",a=await fetch(e,{method:"POST",body:t});await a.json()}catch(e){console.log(e)}}():function(e,t,a){const n=document.querySelector(".alerta");n&&n.remove();const r=document.createElement("DIV");r.classList.add("alerta",t),r.textContent=e,a.parentElement.insertBefore(r,a),setTimeout(()=>{r.remove()},5e3)}("El nombre de la tarea es Obligatorio","error",document.querySelector(".formulario legend"))}()})),document.querySelector(".dashboard").appendChild(e)}));