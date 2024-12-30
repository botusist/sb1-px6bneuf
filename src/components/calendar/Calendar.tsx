import { Calendar as BigCalendar, dateFnsLocalizer } from 'react-big-calendar';
import { format, parse, startOfWeek, getDay } from 'date-fns';
import ptBR from 'date-fns/locale/pt-BR';

const locales = {
  'pt-BR': ptBR,
};

const localizer = dateFnsLocalizer({
  format,
  parse,
  startOfWeek,
  getDay,
  locales,
});

interface CalendarProps {
  events: Array<{
    title: string;
    start: Date;
    end: Date;
  }>;
  onSelectSlot: (slotInfo: { start: Date; end: Date }) => void;
  onSelectEvent: (event: any) => void;
}

export function Calendar({ events, onSelectSlot, onSelectEvent }: CalendarProps) {
  return (
    <div className="h-[600px]">
      <BigCalendar
        localizer={localizer}
        events={events}
        startAccessor="start"
        endAccessor="end"
        selectable
        onSelectSlot={onSelectSlot}
        onSelectEvent={onSelectEvent}
        views={['month', 'week', 'day']}
        defaultView="week"
      />
    </div>
  );
}