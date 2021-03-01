<template>
    <label class="uvm--toggle-container">
        <input v-bind:checked="checked" @change="$emit('change', $event.target.checked)" type="checkbox" hidden="" class="uvm--toggle">
        <div class="uvm--round"></div>
    </label>
</template>

<script>
export default {
    model: {
        event: 'change',
        prop: 'checked'
    },
    props: {
        checked: {
            type: Boolean,
            default: false
        }
    }
}
</script>

<style scoped>
.uvm--round {
	display: -webkit-flex;
	display: -moz-flex;
	display: -ms-flex;
	display: -o-flex;
	display: flex;
	-ms-align-items: center;
	align-items: center;
	background: #E5E5E5;
	width: 100%;
	height: 100%;
	border-radius: 50px;
	position: relative;
	transition: 0.3s;
	cursor: pointer;
	pointer-events: none;
}

.uvm--round:before {
	content: '';
	right: 3px;
	background: #8F8F8F;
	border-radius: 100%;
	width: 10px;
	height: 10px;
	position: absolute;
	transition: 0.4s;
}

.uvm--toggle-container {
	display: -webkit-flex;
	display: -moz-flex;
	display: -ms-flex;
	display: -o-flex;
	display: flex;
	width: 30px;
	height: 15px;
	cursor: pointer;
}

.uvm--toggle {
	pointer-events: none !important;
}

.uvm--toggle-container input:checked + .uvm--round {
	background: #1273eb;
}

.uvm--toggle-container input:checked + .uvm--round:before {
	background: #fff;
	transform: translateX(-14px);
}
</style>