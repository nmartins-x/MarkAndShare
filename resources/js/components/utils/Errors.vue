<template>
    <div class="alert alert-danger" v-if="computedErrors && computedErrors.length">
        Error:
        <ul>
            <li v-for="error in computedErrors">{{ error }}</li>
        </ul>
    </div>
</template>

<script>
    export default {
        props: ['errors'],
        computed: {
            computedErrors: function () {
                var errors = [];
                
                for (let [key, value] of Object.entries(this.errors)) {
                    if(Array.isArray(value) && value.length)
                        errors.push(value[0]);
                }
                
                return errors;
            }
        }
    };
</script>