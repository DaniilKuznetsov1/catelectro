import { clsx, type ClassValue } from 'clsx';
import { twMerge } from 'tailwind-merge';

export function cn(...inputs: ClassValue[]) {
    return twMerge(clsx(inputs));
}

export function getURLPopEnd(sURL) {
  let arr = sURL.split('/');
  if (arr[arr.length-1] == 'dashboard') {
    arr.pop();
  } else if (arr[arr.length-1]=='profile' || arr[arr.length-1]=='api-tokens') {
    arr.pop();
    arr.pop();
  } else if (arr[arr.length-1]=='categorys' || arr[arr.length-1]=='categorysapi' || arr[arr.length-1]=='categorysa') {
    arr.pop();
  }
  return arr.join('/');
}
