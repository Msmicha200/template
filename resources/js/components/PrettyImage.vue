<template>
    <label>
        <input @change="uploadImage" type="file" hidden>
        <img :src="srcImg" alt="">
    </label>
</template>

<script>
export default {
    data() {
        return {
            srcImg: this.src
        }
    },
    model: {
        event: 'change',
        prop: 'src'
    },
    props: {
        src: {
            type: String,
            default: '/images/upload.png'
        }
    },
    methods: {
        uploadImage(event) {
            const file = event.target.files[0];
            const reader = new FileReader();
            
            reader.addEventListener('load', event => {
                this.srcImg = event.target.result;
                this.$emit('change', event.target.result);
            });

            reader.readAsDataURL(file);
        }
    }
}

</script>

<style scoped>
label {
    border: 1px solid black;
    border-radius: 10px;
    width: 150px;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 150px;
    cursor: pointer;
    overflow: hidden;
}

img {
    width: 100%;
    /* height: 100%; */
}
</style>