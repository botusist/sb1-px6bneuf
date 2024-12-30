export type Json =
  | string
  | number
  | boolean
  | null
  | { [key: string]: Json | undefined }
  | Json[]

export interface Database {
  public: {
    Tables: {
      appointments: {
        Row: {
          id: string
          created_at: string
          service_id: string
          provider_id: string
          client_id: string
          start_time: string
          end_time: string
          status: 'pending' | 'confirmed' | 'cancelled'
          notes: string | null
        }
        Insert: {
          id?: string
          created_at?: string
          service_id: string
          provider_id: string
          client_id: string
          start_time: string
          end_time: string
          status?: 'pending' | 'confirmed' | 'cancelled'
          notes?: string | null
        }
        Update: {
          id?: string
          created_at?: string
          service_id?: string
          provider_id?: string
          client_id?: string
          start_time?: string
          end_time?: string
          status?: 'pending' | 'confirmed' | 'cancelled'
          notes?: string | null
        }
      }
      services: {
        Row: {
          id: string
          name: string
          description: string
          duration: number
          price: number
          created_at: string
        }
        Insert: {
          id?: string
          name: string
          description: string
          duration: number
          price: number
          created_at?: string
        }
        Update: {
          id?: string
          name?: string
          description?: string
          duration?: number
          price?: number
          created_at?: string
        }
      }
      providers: {
        Row: {
          id: string
          user_id: string
          name: string
          email: string
          phone: string
          specialization: string
          created_at: string
        }
        Insert: {
          id?: string
          user_id: string
          name: string
          email: string
          phone: string
          specialization: string
          created_at?: string
        }
        Update: {
          id?: string
          user_id?: string
          name?: string
          email?: string
          phone?: string
          specialization?: string
          created_at?: string
        }
      }
    }
  }
}