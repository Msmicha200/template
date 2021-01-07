<template>
    <div :class="{'visible' : active}" @click="active = false" class="modal-background">
        <div class="modal-content" @click.stop="">
            <slot :close="close"></slot>
        </div>
    </div>
</template>

<script>

export default {
    data: function () {
        return {
            active: false
        }
    },
    methods: {
        close() {
            this.active = false;
        }
    },
    watch: {
        active: function () {
            if (this.active) {
                document.documentElement.style.overflow = 'hidden';
                return;
            }
            
            document.documentElement.style.overflow = 'auto';
        }
    }
}
</script>

<style scoped>
.modal-background {
    z-index: 999;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(241,247,250,.99);
    display: flex;
    justify-content: center;
    align-items: center;
    display: none;
}

.visible {
    animation: appear .3s cubic-bezier(0,0,.2,1);
    display: flex;
}

@keyframes appear {
    0% {
        opacity: 0;
        top: 100px;
    }
    100% {
        top: 0;
        opacity: 1;
    }
}

.modal-content {
    position: relative;
    background: #fff;
    max-width: 1100px;
    width: 100%;
    /* height: 500px; */
    border-radius: 10px;
}
</style>