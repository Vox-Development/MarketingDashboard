<template>
    <grid :position="grid" modifiers="google-trends padded fa fa-bars fa-sort-desc">
        <section class="google-trends">
            <h1 class="google-trends__title">Google <span>Trends</span></h1>
            <div class="google-trends__content">{{ contents }}</div>
        </section>
    </grid>
</template>

<script>
import echo from '../mixins/echo';
import Grid from './Grid';
import saveState from 'vue-save-state';
const googleTrends = require('google-trends-api');


 export default {
    components: {
        Grid,
    },

    mixins: [echo, saveState],

    props: ['google-trends', 'grid'],

    data() {
        return {
            contents: 'List of email marketing trends',
        }
    },

    mounted() {
        this.getGoogleTrends();
    },

    methods: {
        getGoogleTrends() {
             //console.log(googleTrends);
             googleTrends.interestOverTime({ keyword: 'Marketing' })
             .then(function(results) {
                 //contents = results;
                 console.log(results);
             })
             .catch(function(err) {
                //this.contents = "Error retrieving trends";
                console.error('Oh no there was an error', err);
             })
         },

        getEventHandlers() {
            return {}
        },

        getSaveStateConfig() {
            return {
                cacheKey: `google-trends`,
            };
        },
    },
};
</script>
