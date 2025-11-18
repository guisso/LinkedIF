import { Toaster } from "@/components/ui/toaster";
import { Toaster as Sonner } from "@/components/ui/sonner";
import { TooltipProvider } from "@/components/ui/tooltip";
import { BrowserRouter, Routes, Route } from "react-router-dom";
import Index from "./pages/Index";
import Perfis from "./pages/Perfis";
import NotFound from "./pages/NotFound";
import Vagas from "./pages/Vagas";

const App = () => (
  <TooltipProvider>
    <Toaster />
    <Sonner />
    <BrowserRouter>
      <Routes>
        <Route path="/" element={<Index />} />
        <Route path="/perfis" element={<Perfis />} />
        <Route path="*" element={<NotFound />} />
        <Route path="/vagas" element={<Vagas />} />
      </Routes>
    </BrowserRouter>
  </TooltipProvider>
);

export default App;
