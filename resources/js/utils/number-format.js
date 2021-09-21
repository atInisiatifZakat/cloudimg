export default function numberFormat(value) {
  const number = Number(value);

  if (isNaN(number) === false) {
    return Intl.NumberFormat('id').format(number.toFixed(2));
  }

  return '0,00';
}
