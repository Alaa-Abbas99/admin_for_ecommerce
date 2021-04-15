<template>
<div>
    
    <div class="input-group-append">
        <label class="btn btn-primary"> 
                Upload <input type="file" hidden @change="upload($event.target.files)"/>
        </label>
        
    </div>
</div>          
</template>

<script >

import axios from "axios";




export default {
    name: "ImageUpload",
    emits: ['file-uploaded'],
    setup(_ , context){

        const upload = async (files) => {
            const file = files.item(0);

            const data = new FormData;
            data.append('image', file);

            const res = await axios.post('/upload', data);
            context.emit('file-uploaded', res.data.url);
        }

        return{
            upload,      
        };
  }

}
</script>