<template>
    <div class="full-w">
        <Navbar />
        <main class="full-w">
        	<slot />
        </main>
        <Footer />
    </div>
</template>

<script>
import Navbar from '@/components/Navbar.vue';
import Footer from '@/components/Footer.vue';

export default {
    components: {
        Navbar,
        Footer
    }
}
</script>