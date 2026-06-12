import React, { useState } from 'react';

function App() {
  const [tasks, setTasks] = useState([
    { id: 1, title: 'Membuat Desain UI', status: 'todo' },
    { id: 2, title: 'Setup Project Vite React', status: 'in-progress' },
    { id: 3, title: 'Belajar Fundamental React', status: 'done' },
  ]);
  const [inputTask, setInputTask] = useState('');

  const handleAddTask = (e) => {
    e.preventDefault();
    if (!inputTask.trim()) return;
    const newTask = { id: Date.now(), title: inputTask, status: 'todo' };
    setTasks([...tasks, newTask]);
    setInputTask('');
  };

  const moveTask = (id, nextStatus) => {
    setTasks(tasks.map(task => task.id === id ? { ...task, status: nextStatus } : task));
  };

  const deleteTask = (id) => {
    setTasks(tasks.filter(task => task.id !== id));
  };

  const getTasksByStatus = (status) => tasks.filter(task => task.status === status);

  return (
    <div className="min-h-screen bg-slate-100 font-sans pb-10">
      {/* HEADER / NAVBAR */}
      <nav className="bg-white border-b border-slate-200 px-6 py-4 shadow-xs mb-8">
        <div className="max-w-7xl mx-auto flex justify-between items-center">
          <h1 className="text-2xl font-bold text-slate-800 tracking-tight">
            📋 <span className="bg-gradient-to-r bg-clip-text text-transparent from-blue-600 to-indigo-600">Kanban Board</span>
          </h1>
          <span className="text-xs font-semibold bg-blue-50 text-blue-600 px-3 py-1.5 rounded-full border border-blue-100">
            Miniclass 2026
          </span>
        </div>
      </nav>

      <div className="max-w-6xl mx-auto px-4">
        {/* FORM INPUT */}
        <form onSubmit={handleAddTask} className="flex justify-center gap-2 mb-8 max-w-md mx-auto">
          <input 
            type="text" 
            placeholder="Tambah tugas baru..." 
            value={inputTask}
            onChange={(e) => setInputTask(e.target.value)}
            className="flex-1 px-4 py-2.5 bg-white border border-slate-300 rounded-lg text-sm shadow-xs focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-slate-700"
          />
          <button type="submit" className="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm rounded-lg shadow-xs transition-colors cursor-pointer">
            Tambah
          </button>
        </form>

        {/* CONTAINER PAPAN KANBAN */}
        <div className="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">
          
          {/* KOLOM TO DO */}
          <div className="bg-slate-50 border border-slate-200 rounded-xl p-4 min-h-[450px]">
            <div className="flex justify-between items-center mb-4 px-1">
              <h3 className="font-bold text-slate-700 text-base">To Do</h3>
              <span className="bg-slate-200 text-slate-700 text-xs font-bold px-2.5 py-0.5 rounded-full">{getTasksByStatus('todo').length}</span>
            </div>
            <div className="space-y-3">
              {getTasksByStatus('todo').map(task => (
                <div key={task.id} className="bg-white p-4 rounded-lg border border-slate-200 shadow-xs hover:shadow-md transition-shadow">
                  <p className="text-slate-700 text-sm font-medium mb-4">{task.title}</p>
                  <div className="flex justify-between items-center">
                    <button onClick={() => moveTask(task.id, 'in-progress')} className="text-xs font-medium bg-amber-50 text-amber-700 border border-amber-200 px-3 py-1.5 rounded-md hover:bg-amber-100 cursor-pointer transition-colors">Proses →</button>
                    <button onClick={() => deleteTask(task.id)} className="text-xs font-medium bg-rose-50 text-rose-600 px-3 py-1.5 rounded-md hover:bg-rose-100 cursor-pointer transition-colors">Hapus</button>
                  </div>
                </div>
              ))}
            </div>
          </div>

          {/* KOLOM IN PROGRESS */}
          <div className="bg-slate-50 border border-slate-200 rounded-xl p-4 min-h-[450px]">
            <div className="flex justify-between items-center mb-4 px-1">
              <h3 className="font-bold text-slate-700 text-base">In Progress</h3>
              <span className="bg-blue-100 text-blue-700 text-xs font-bold px-2.5 py-0.5 rounded-full">{getTasksByStatus('in-progress').length}</span>
            </div>
            <div className="space-y-3">
              {getTasksByStatus('in-progress').map(task => (
                <div key={task.id} className="bg-white p-4 rounded-lg border border-slate-200 shadow-xs hover:shadow-md transition-shadow border-l-4 border-l-blue-500">
                  <p className="text-slate-700 text-sm font-medium mb-4">{task.title}</p>
                  <div className="flex justify-between items-center gap-2">
                    <button onClick={() => moveTask(task.id, 'todo')} className="text-xs font-medium bg-slate-100 text-slate-600 px-2.5 py-1.5 rounded-md hover:bg-slate-200 cursor-pointer transition-colors">← Kembali</button>
                    <button onClick={() => moveTask(task.id, 'done')} className="text-xs font-medium bg-emerald-600 text-white px-3 py-1.5 rounded-md hover:bg-emerald-700 cursor-pointer transition-colors">Selesai →</button>
                  </div>
                </div>
              ))}
            </div>
          </div>

          {/* KOLOM DONE */}
          <div className="bg-slate-50 border border-slate-200 rounded-xl p-4 min-h-[450px]">
            <div className="flex justify-between items-center mb-4 px-1">
              <h3 className="font-bold text-emerald-700 text-base">Done</h3>
              <span className="bg-emerald-100 text-emerald-700 text-xs font-bold px-2.5 py-0.5 rounded-full">{getTasksByStatus('done').length}</span>
            </div>
            <div className="space-y-3">
              {getTasksByStatus('done').map(task => (
                <div key={task.id} className="bg-white p-4 rounded-lg border border-slate-200 shadow-xs border-l-4 border-l-emerald-500">
                  <p className="text-slate-400 text-sm font-medium line-through mb-4">{task.title}</p>
                  <div className="flex justify-between items-center">
                    <button onClick={() => moveTask(task.id, 'in-progress')} className="text-xs font-medium bg-slate-100 text-slate-600 px-2.5 py-1.5 rounded-md hover:bg-slate-200 cursor-pointer transition-colors">← Tarik</button>
                    <button onClick={() => deleteTask(task.id)} className="text-xs font-medium bg-rose-50 text-rose-600 px-3 py-1.5 rounded-md hover:bg-rose-100 cursor-pointer transition-colors">Bersihkan</button>
                  </div>
                </div>
              ))}
            </div>
          </div>

        </div>
      </div>
    </div>
  );
}

export default App;