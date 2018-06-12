<template>
    <grid :position="grid" modifiers="padded transparent">
        <section :class="addClassModifiers('rain-forecast', status)">
            <h1 v-if="status == 'dry'">{{ forecast.chanceOfRain }}°C <strong style="color:#fff">{{ forecast.description }}</strong></h1>
            <h1 class="rain-forecast__title rain-forecast__title--rainy" v-if="status == 'rainy'"><i class="fa fa-tint" aria-hidden="true"></i> {{ forecast.chanceOfRain }}°C {{ forecast.description }}</h1>
            <h1 class="rain-forecast__title rain-forecast__title--rainy" v-if="status == 'wet'"><i class="fa fa-sun-o" aria-hidden="true"></i> {{ forecast.chanceOfRain }}°C {{ forecast.description }}</h1>
            <div class="rain-forecast__background"></div>
            <div class="rain-forecast__graph" >
                <graph
                  :labels="graphLabels"
                  :values="graphData"
                  line-color="rgba(19,134,158, .5)"
                  background-color="rgba(19,134,158, .25)"
                ></graph>
            </div>
        </section>
    </grid>
</template>

<script>
import { filter, map, sumBy } from 'lodash';
import echo from '../mixins/echo';
import Graph from './Graph';
import Grid from './Grid';
import { addClassModifiers } from '../helpers';

export default {

    components: {
        Grid,
        Graph,
    },

    mixins: [echo],

    props: ['grid'],

    computed: {
        status() {
            if (this.noRainPredicted === true) {
                return 'dry';
            }

            if (this.HeavyRainPredicted === true) {
                return 'wet';
            }

            return 'rainy';
        },

        noRainPredicted() {
            const rainScore = filter(this.forecast, foreCastItem => {
                return parseInt(foreCastItem.chanceOfRain);
            });

            return rainScore < 32;
        },

        HeavyRainPredicted() {
            const foreCastItemWithRain = filter(this.forecast, foreCastItem => {
                return parseInt(foreCastItem.chanceOfRain); // it will rain true
            });

            return foreCastItemWithRain > 40;
        },

        graphLabels() {
            return map(this.forecast, 'description');
        },

        graphData() {
            return map(this.forecast, 'chanceOfRain');
        },
    },

    data() {
        return {
            forecast: []
        };
    },

    methods: {
        addClassModifiers,

        getEventHandlers() {
            return {
                'RainForecast.ForecastFetched': response => {
                    this.forecast = response.forecast;
                },
            };
        },
    },
};
</script>
