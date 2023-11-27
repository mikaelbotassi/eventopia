export function formatarDataHora(data: string): string {
    const options: Intl.DateTimeFormatOptions = {
      year: 'numeric',
      month: 'numeric',
      day: 'numeric',
      hour: 'numeric',
      minute: 'numeric',
      second: 'numeric',
      hour12: false,
      timeZone: 'America/Sao_Paulo', // Ajuste conforme necessário
    };
  
    const formatter = new Intl.DateTimeFormat('pt-BR', options);
    return formatter.format(new Date(data));
}