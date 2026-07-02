/** Tailwind CLI yapılandırması (optimize.sh ile derleme için).
 *  header.php'deki inline tailwind.config'in birebir karşılığı. */
module.exports = {
  content: ["./*.php", "./includes/*.php"],
  theme: {
    extend: {
      colors: {
        ink: '#15181D', anthracite: '#1E232B', steel: '#2A3038',
        midnight: '#0E1A2B', signal: '#3D7DD8', signalDim: '#2C5FA8',
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
