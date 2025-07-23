import { initMouseFollowers } from './mouse-follower-front.js';
import { containerRotation } from './container-rotation.js';

document.addEventListener('DOMContentLoaded', () => {
  initMouseFollowers();
  containerRotation();
});