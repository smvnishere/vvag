/** Tailwind CLI yapılandırması (optimize.sh ile derleme için).
 *  header.php'deki inline tailwind.config'in birebir karşılığı. */
module.exports = {
  content: ["./*.php", "./includes/*.php"],
  theme: {
    extend: {
      colors: {
        abyss: '#0B0E13', ink: '#12161D', anthracite: '#1B212B',
        steel: '#2B333F', midnight: '#0E141D',
        signal: '#FF7A00', signalDim: '#FF9633',
        fog: '#F4F5F7', mist: '#E6E8EC',
      },
      fontFamily: {
        display: ['Saira', 'sans-serif'],
        body: ['Inter', 'sans-serif'],
        mono: ['"IBM Plex Mono"', 'monospace'],
      },
    },
  },
};
