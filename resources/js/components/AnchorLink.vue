<template>
    <a @click.prevent="move">
        <slot />
    </a>
</template>

<script>
export default {
    props: {
        href: {
            type: String,
            default: '#'
        },
        offsetAway: {
            type: [String, Number],
            default: 0
        }
    },
    methods: {
        move() {
            const target = document.getElementById(this.href.replace(/[#]/, ''));
            
            if (!target) return;
            
            const elemPosition = target.getBoundingClientRect().top - this.offsetAway;

            window.scrollBy({
                top: elemPosition,
                behavior: 'smooth'
            })
        }
    }
}
</script>

<style scoped>
a {
    font-family: sans-serif;
    font-weight: 100;
    cursor: pointer;
    display: block;
    transition: .2s;
}

a:hover {
    color: #0068a6;
}

a::after {
    margin-top: 3px;
    content: '';
    height: 2px;
    width: 100%;
    display: block;
    transform: scaleX(0);
    transform-origin: center;
    background: #0068a6;
    transition: .2s;
}

a:hover:after {
    transform: scaleX(1);
}
</style>
